<template>
  <div v-show="$route.path === '/categories'" class="map-container">
    <h2>Автомойки на карте</h2>
    <div id="map"></div>

    <!-- Модальное окно записи -->
    <div v-if="isBookingModalOpen" class="modal">
      <div class="modal-content">
        <h3>Запись на автомойку</h3>
        <p><strong>{{ selectedCarWash?.name }}</strong></p>

        <!-- Выбор доступного времени -->
        <label for="appointment_time">Выберите время:</label>
        <div class="time-grid">
          <button
              v-for="time in availableTimes"
              :key="time"
              :class="{'selected': bookingData.appointment_time === time}"
              @click="bookingData.appointment_time = time">
            {{ time }}
          </button>
        </div>

        <form @submit.prevent="submitBooking">
          <button type="submit" class="confirm">Записаться</button>
          <button type="button" class="cancel" @click="closeBookingModal">Отмена</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
/* global ymaps */
import { nextTick } from "vue";

export default {
  data() {
    return {
      carWashes: [],
      isBookingModalOpen: false,
      selectedCarWash: null,
      bookingData: {
        appointment_time: "",
      },
      availableTimes: [],
    };
  },

  mounted() {
    this.loadYandexMaps();
  },

  methods: {
    // 🚀 Загружаем API Яндекс.Карт
    loadYandexMaps() {
      if (window.ymaps) {
        this.fetchCarWashes();
      } else {
        const script = document.createElement("script");
        script.src =
            "https://api-maps.yandex.ru/2.1/?apikey=76f6b516-5c18-4370-aafa-99336be9b94a&lang=ru_RU";
        script.onload = () => this.fetchCarWashes();
        document.head.appendChild(script);
      }
    },

    // 🚀 Загружаем список автомоек
    async fetchCarWashes() {
      try {
        const response = await fetch("http://localhost:8000/api/car-washes");
        if (!response.ok) throw new Error("Ошибка загрузки данных");
        const data = await response.json();
        this.carWashes = data.data || data;
        this.waitForMapElement();
      } catch (error) {
        console.error("Ошибка при получении данных:", error);
      }
    },

    // 🚀 Ждём появления карты перед инициализацией
    waitForMapElement() {
      nextTick(() => {
        setTimeout(() => {
          const mapElement = document.getElementById("map");
          if (!mapElement) {
            setTimeout(this.waitForMapElement, 100);
            return;
          }
          this.initMap();
        }, 500);
      });
    },

    // 🚀 Инициализация карты
    initMap() {
      ymaps.ready(() => {
        this.map = new ymaps.Map("map", {
          center: [43.222, 76.851],
          zoom: 12,
        });
        this.addCarWashes();
      });
    },

    // 🚀 Добавляем метки автомоек на карту
    addCarWashes() {
      this.carWashes.forEach((wash) => {
        if (wash.latitude && wash.longitude) {
          let placemark = new ymaps.Placemark(
              [wash.latitude, wash.longitude],
              {
                balloonContent: `
                <strong>${wash.name}</strong><br>
                Описание: ${wash.description || "Нет информации"}<br>
                Телефон: ${wash.phone || "Не указан"}<br>
                Instagram: <a href="${wash.instagram}" target="_blank">${wash.instagram || "Не указан"}</a><br>
                <button class="booking-btn" onclick="window.vueInstance.openBookingModal('${wash.id}')">Записаться</button>
              `,
              }
          );
          this.map.geoObjects.add(placemark);
        }
      });

      window.vueInstance = this;
    },

    async openBookingModal(carWashId) {
      this.selectedCarWash = this.carWashes.find((w) => w.id == carWashId);
      this.isBookingModalOpen = true;

      try {
        const response = await fetch(`http://localhost:8000/api/available-slots/${carWashId}`);
        if (!response.ok) throw new Error("Ошибка загрузки расписания");

        const schedule = await response.json();
        console.log("Расписание с бэка:", schedule);
        this.availableTimes = schedule;

      } catch (error) {
        console.error("Ошибка загрузки расписания:", error);
        this.availableTimes = [];
      }
    },

    // 🚀 Закрываем модальное окно записи
    closeBookingModal() {
      this.isBookingModalOpen = false;
      this.bookingData.appointment_time = "";
    },

    // 🚀 Отправляем запрос на запись
    async submitBooking() {
      if (!this.selectedCarWash || !this.bookingData.appointment_time) return;

      try {
        const response = await fetch("http://localhost:8000/api/booking/store", {
          method: "POST",
          headers: {"Content-Type": "application/json"},
          body: JSON.stringify({
            car_wash_id: this.selectedCarWash.id,
            appointment_time: this.bookingData.appointment_time,
          }),
        });

        if (!response.ok) throw new Error("Ошибка записи");
        alert("Вы успешно записаны!");
        this.closeBookingModal();
      } catch (error) {
        console.error("Ошибка при записи:", error);
        alert("Ошибка записи, попробуйте позже.");
      }
    },
  },
};
</script>

<style scoped>
.map-container {
  width: 100%;
  height: 500px;
  position: relative;
}

#map {
  width: 100%;
  height: 100%;
}

.modal {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.modal-content {
  text-align: center;
}

.time-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
  margin: 15px 0;
}

.time-grid button {
  padding: 10px;
  background: #f1f1f1;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  transition: 0.3s;
}

.time-grid button.selected {
  background: #007bff;
  color: white;
}

.time-grid button:hover {
  background: #0056b3;
  color: white;
}

button {
  margin: 10px;
  padding: 10px 15px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
}

button.confirm {
  background: #28a745;
  color: white;
}

button.cancel {
  background: #dc3545;
  color: white;
}

button:hover {
  opacity: 0.8;
}
</style>
