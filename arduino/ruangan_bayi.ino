#include <ESP8266WiFi.h>
#include <DHT.h>
#include <ArduinoJson.h>

// ============ KONFIGURASI DHT11 ============
#define DHTPIN D4       // Menggunakan D4 sesuai permintaan
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

// ============ KONFIGURASI RELAY & LED ============
#define PIN_KIPAS D3       // Relay 1 (Kipas 1)
#define PIN_KIPAS2 D6      // Relay 2 (Kipas 2)
#define PIN_LAMPU_BIRU D2  // LED Biru (Active High)
#define PIN_PENGHANGAT D7  // Relay 4 (Lampu Pijar) 
#define PIN_LAMPU_MERAH D1 // LED Merah (Active High)

// ============ KONFIGURASI WIFI & API ============
const char* ssid = "-";               // Sesuaikan dengan WiFi Anda
const char* password = "arpan123";
const char* serverIP = "seraviel.my.id";        // Domain Anda
const int serverPort = 80;
const char* apiEndpoint = "/api/monitoring/store";

// Device ID unik otomatis berdasarkan Chip ID ESP8266
// ID Device harus sama dengan yang terdaftar di menu "Manajemen Device" di website
const char* deviceId = "DEVICE_TESFY4MS2M_1778687077"; 

// ============ VARIABEL WAKTU ============
unsigned long lastReadTime = 0;
unsigned long lastSendTime = 0;

void setup() {
  Serial.begin(115200);
  delay(100);

  // Ambil Chip ID unik (Dimatikan karena menggunakan ID statis MAIN_DEVICE agar sinkron dengan web)
  // deviceId = "ESP-" + String(ESP.getChipId());
  Serial.println("\nDevice ID: " + String(deviceId));

  // Inisialisasi Pin Relay sebagai OUTPUT
  pinMode(PIN_KIPAS, OUTPUT);
  pinMode(PIN_KIPAS2, OUTPUT);
  pinMode(PIN_LAMPU_BIRU, OUTPUT);
  pinMode(PIN_PENGHANGAT, OUTPUT);
  pinMode(PIN_LAMPU_MERAH, OUTPUT);

  // Matikan semua sebagai default (Relay modul biasanya Low Trigger, sesuaikan jika perlu)
  digitalWrite(PIN_KIPAS, HIGH);
  digitalWrite(PIN_KIPAS2, HIGH);
  digitalWrite(PIN_LAMPU_BIRU, LOW);
  digitalWrite(PIN_PENGHANGAT, HIGH);
  digitalWrite(PIN_LAMPU_MERAH, LOW);

  Serial.println("\n\n=== SISTEM MONITORING SUHU BAYI ===");
  dht.begin();
  delay(2000); // Waktu pemanasan sensor

  // Koneksi ke WiFi
  WiFi.mode(WIFI_STA);
  WiFi.setAutoConnect(true);
  WiFi.setAutoReconnect(true);
  WiFi.begin(ssid, password);
  
  Serial.print("Menghubungkan ke WiFi");
  int retryCount = 0;
  while (WiFi.status() != WL_CONNECTED && retryCount < 20) {
    delay(500);
    Serial.print(".");
    retryCount++;
  }
  
  if (WiFi.status() == WL_CONNECTED) {
    Serial.println("\n✅ WiFi TERHUBUNG! IP: " + WiFi.localIP().toString());
  } else {
    Serial.println("\n❌ WiFi Gagal terhubung. Cek SSID/Password.");
  }
}

void controlDevices(float t) {
  if (t >= 31.0) {
    // Suhu panas (> 31): 2 Kipas & Lampu Merah ON
    digitalWrite(PIN_KIPAS, LOW);
    digitalWrite(PIN_KIPAS2, LOW);
    digitalWrite(PIN_LAMPU_MERAH, HIGH);
    digitalWrite(PIN_LAMPU_BIRU, LOW);
    digitalWrite(PIN_PENGHANGAT, HIGH);
    Serial.println("⚙️  Kondisi: PANAS (> 31) -> 2 Kipas & LED Merah ON");
  } 
  else if (t <= 29.0) {
    // Suhu dingin (< 29): Penghangat & Lampu Biru ON
    digitalWrite(PIN_KIPAS, HIGH);
    digitalWrite(PIN_KIPAS2, HIGH);
    digitalWrite(PIN_LAMPU_BIRU, HIGH);
    digitalWrite(PIN_LAMPU_MERAH, LOW);
    digitalWrite(PIN_PENGHANGAT, LOW);
    Serial.println("⚙️  Kondisi: DINGIN (< 29) -> Penghangat & LED Biru ON");
  } 
  else {
    // Suhu normal (29 - 31): 1 Kipas ON
    digitalWrite(PIN_KIPAS, LOW);
    digitalWrite(PIN_KIPAS2, HIGH);
    digitalWrite(PIN_LAMPU_BIRU, LOW);
    digitalWrite(PIN_LAMPU_MERAH, LOW);
    digitalWrite(PIN_PENGHANGAT, HIGH);
    Serial.println("⚙️  Kondisi: NORMAL (29-31) -> 1 Kipas ON");
  }
}

void loop() {
  // Cek koneksi WiFi
  if (WiFi.status() != WL_CONNECTED) {
    static unsigned long lastWiFiCheck = 0;
    if (millis() - lastWiFiCheck > 5000) {
      Serial.println("📡 WiFi terputus, mencoba menyambung kembali...");
      WiFi.begin(ssid, password);
      lastWiFiCheck = millis();
    }
    return;
  }

  // 1. Baca Sensor Setiap 2 Detik
  if (millis() - lastReadTime >= 2000) {
    lastReadTime = millis();
    
    float h = dht.readHumidity();
    float t = dht.readTemperature();

    if (isnan(h) || isnan(t)) {
      Serial.println("⚠️ Gagal membaca sensor DHT11! Cek kabel di pin D4.");
      return;
    }

    // Tampilkan di Serial Monitor
    Serial.print("🌡️ Suhu: "); Serial.print(t); Serial.print("°C | ");
    Serial.print("💧 Lembap: "); Serial.print(h); Serial.println("%");

    // 2. Kendalikan Kipas/Lampu berdasarkan suhu terbaru
    controlDevices(t);

    // 3. Kirim Data ke Laravel Setiap 10 Detik
    if (millis() - lastSendTime >= 10000) {
      lastSendTime = millis();
      sendDataToLaravel(t, h);
    }
  }
}

void sendDataToLaravel(float t, float h) {
  WiFiClient client;
  
  Serial.println("📡 Menghubungkan ke Server: " + String(serverIP) + ":" + String(serverPort));
  
  if (!client.connect(serverIP, serverPort)) {
    Serial.println("❌ Gagal terhubung ke Server. Pastikan Laravel sudah jalan dengan: php artisan serve --host 0.0.0.0");
    return;
  }

  // Buat JSON payload
  StaticJsonDocument<256> doc;
  doc["device_id"] = deviceId; // Kirim Chip ID unik
  doc["temperature"] = t;
  doc["humidity"] = h;

  String jsonPayload;
  serializeJson(doc, jsonPayload);

  // Kirim HTTP POST request
  String request = "POST " + String(apiEndpoint) + " HTTP/1.1\r\n";
  request += "Host: " + String(serverIP) + ":" + String(serverPort) + "\r\n";
  request += "Content-Type: application/json\r\n";
  request += "Content-Length: " + String(jsonPayload.length()) + "\r\n";
  request += "Connection: close\r\n\r\n";
  request += jsonPayload;

  client.print(request);
  Serial.println("✅ Data terkirim, menunggu respons...");

  // Baca respons
  unsigned long timeout = millis();
  while (client.connected() || client.available()) {
    if (client.available()) {
      String line = client.readStringUntil('\n');
      if (line.indexOf("200 OK") > -1 || line.indexOf("201 Created") > -1) {
        Serial.println("✨ SUKSES! Data berhasil masuk ke dashboard.");
        break;
      }
    }
    if (millis() - timeout > 5000) {
      Serial.println("⏳ Timeout menunggu respons server.");
      break;
    }
  }
  
  client.stop();
  Serial.println("----------------------------------------");
}