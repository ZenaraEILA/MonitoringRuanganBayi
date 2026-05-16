# 📡 KONFIGURASI ESP8266 untuk Production Server

## 1️⃣ ESP8266 HARUS SEND DATA KE:

```
Server URL: http://192.168.137.67/api/monitoring/store
            atau
            http://[SERVER_IP]/api/monitoring/store

Method: POST
Content-Type: application/json

Format Data:
{
  "device_id": "DEVICE-BAYI-001",
  "temperature": 24.5,
  "humidity": 65.2,
  "pressure": 1013.25,
  "recorded_at": "2026-05-13 10:30:45"
}
```

## 2️⃣ DEVICE ID YANG VALID:

ESP8266 harus pakai `device_id` yang sama dengan database:
- ✅ `DEVICE-BAYI-001` (sudah setup di database)
- ❌ Jangan pakai ID lain jika belum di-register di database

## 3️⃣ FREQUENCY PENGIRIMAN DATA:

Rekomendasinya:
- **Setiap 5 menit** untuk pembacaan normal
- **Setiap 1 menit** jika ada alert/warning
- **Real-time** jika ada anomali temperature

## 4️⃣ API ENDPOINT untuk MONITORING DATA:

### GET data monitoring terakhir:
```
GET /api/monitoring/device/DEVICE-BAYI-001
Response:
{
  "device_id": "DEVICE-BAYI-001",
  "temperature": 24.5,
  "humidity": 65.2,
  "pressure": 1013.25,
  "recorded_at": "2026-05-13 10:30:45"
}
```

### GET historical data:
```
GET /api/monitoring/device/DEVICE-BAYI-001?days=7
```

### POST data baru:
```
POST /api/monitoring/store
{
  "device_id": "DEVICE-BAYI-001",
  "temperature": 24.5,
  "humidity": 65.2,
  "pressure": 1013.25,
  "recorded_at": "2026-05-13 10:30:45"
}
```

## 5️⃣ CONTOH CODE ESP8266 (Arduino):

```cpp
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <ArduinoJson.h>

const char* ssid = "YOUR_WIFI_SSID";
const char* password = "YOUR_WIFI_PASSWORD";
const char* serverUrl = "http://192.168.137.67/api/monitoring/store";
const char* deviceId = "DEVICE-BAYI-001";

void setup() {
  Serial.begin(115200);
  WiFi.begin(ssid, password);
  // ... wait for connection
}

void loop() {
  // Baca sensor
  float temp = readTemperature();   // dari DHT22 misalnya
  float humidity = readHumidity();
  
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(serverUrl);
    http.addHeader("Content-Type", "application/json");
    
    // Buat JSON
    StaticJsonDocument<200> doc;
    doc["device_id"] = deviceId;
    doc["temperature"] = temp;
    doc["humidity"] = humidity;
    doc["pressure"] = 1013.25;
    doc["recorded_at"] = getDateTime(); // misal: "2026-05-13 10:30:45"
    
    String payload;
    serializeJson(doc, payload);
    
    int httpCode = http.POST(payload);
    if (httpCode == 200) {
      Serial.println("Data sent successfully!");
    }
    http.end();
  }
  
  delay(300000); // Tunggu 5 menit
}
```

## 6️⃣ DEBUGGING:

Jika ESP8266 tidak bisa send data:
1. Cek WiFi connection
2. Cek IP address si ESP sama dengan SERVER IP
3. Test manual: `curl -X POST http://192.168.137.67/api/monitoring/store -d '{"device_id":"DEVICE-BAYI-001","temperature":24.5,"humidity":65.2,"pressure":1013.25,"recorded_at":"2026-05-13 10:30:45"}' -H "Content-Type: application/json"`
4. Cek server logs: `tail -f storage/logs/laravel.log`

---

**Catatan**: Server dimulai pada IP `192.168.137.67` - sesuaikan jika IP berubah!
