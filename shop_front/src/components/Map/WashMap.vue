<template>
  <div class="map-container">
    <div id="map" class="map"></div>
    <div v-if="showBookingModal" class="modal">
      <div class="modal-content">
        <h2>Бронирование автомойки</h2>
        <p><strong>{{ selectedCarWash?.name }}</strong></p>
        <label>Выберите время:</label>
        <input type="time" v-model="bookingData.time" />
        <button @click="submitBooking">Записаться</button>
        <button @click="closeBookingModal">Закрыть</button>
      </div>
    </div>
  </div>
</template>

<script>
/* global ymaps */
export default {
  data() {
    return {
      map: null,
      carWashes: [],
      showBookingModal: false,
      selectedCarWash: null,
      bookingData: {
        time: "",
      },
    };
  },
  computed: {
    authToken() {
      return localStorage.getItem("access_token") || "";
    },
  },
  mounted() {
    this.loadYandexMap();
  },
  methods: {
    loadYandexMap() {
      if (!window.ymaps) {
        const script = document.createElement("script");
        script.src =
            "https://api-maps.yandex.ru/2.1/?apikey=76f6b516-5c18-4370-aafa-99336be9b94a&lang=ru_RU";
        script.onload = () => ymaps.ready(this.initMap);
        document.head.appendChild(script);
      } else {
        ymaps.ready(this.initMap);
      }
    },
    initMap() {
      this.map = new ymaps.Map("map", {
        center: [43.238949, 76.889709], // Алматы
        zoom: 12,
        controls: ["zoomControl", "fullscreenControl"],
      });
      this.fetchCarWashes();
    },
    async fetchCarWashes() {
      try {
        const response = await fetch("http://localhost:8000/api/car-washes/");
        if (!response.ok) throw new Error(`Ошибка: ${response.status}`);
        this.carWashes = await response.json();
        this.addMarkers();
      } catch (error) {
        console.error("Ошибка загрузки автомоек:", error);
      }
    },
    addMarkers() {
      this.carWashes.forEach((wash) => {
        const placemark = new ymaps.Placemark(
            [wash.latitude, wash.longitude],
            {
              hintContent: wash.name,
              balloonContentHeader: `<strong>${wash.name}</strong>`,
              balloonContentBody: `
              Описание: ${wash.description || "Нет информации"}<br>
              Телефон: ${wash.phone || "Не указан"}<br>
              <button onclick="window.openBooking(${wash.id})">Записаться</button>
            `,
            },
            {
              preset: "islands#blueAutoIcon",
            }
        );

        this.map.geoObjects.add(placemark);
      });

      window.openBooking = (id) => {
        const app = document.getElementById("app").__vue_app__.config.globalProperties.$root;
        app.openBookingModal(id);
      };
    },
    openBookingModal(id) {
      this.selectedCarWash = this.carWashes.find((wash) => wash.id === id);
      this.showBookingModal = true;
    },
    closeBookingModal() {
      this.showBookingModal = false;
      this.selectedCarWash = null;
      this.bookingData.time = "";
    },
    async submitBooking() {
      if (!this.selectedCarWash || !this.bookingData.time) {
        alert("Выберите автомойку и время!");
        return;
      }

      try {
        const response = await fetch("http://localhost:8000/api/book-slot/", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${this.authToken}`,
          },
          body: JSON.stringify({
            car_wash_id: this.selectedCarWash.id,
            date: new Date().toISOString().split("T")[0],
            time: this.bookingData.time,
          }),
        });

        if (!response.ok) throw new Error(`Ошибка: ${response.statusText}`);
        alert("Вы успешно записаны!");
        this.closeBookingModal();
      } catch (error) {
        console.error("Ошибка бронирования:", error);
        alert("Не удалось записаться.");
      }
    },
  },
};
</script>

<style>
.map-container {
  position: relative;
  width: 100%;
  height: 500px;
}
.map {
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
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  z-index: 1000;
}
.modal-content {
  display: flex;
  flex-direction: column;
  align-items: center;
}
</style>
