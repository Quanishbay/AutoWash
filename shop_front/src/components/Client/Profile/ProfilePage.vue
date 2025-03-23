<script>
import axios from "axios";

export default {
  data() {
    return {
      userData: '',
      historyData: '',
      selectedFile: null, // Для загрузки фото
      userPhotoUrl: '',    // Для отображения фото
    }
  },
  methods: {
    getInfo() {
      axios.post('http://localhost:8000/api/auth/me', {}, {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('access_token')}`
        }
      })
          .then(response => {
            this.userData = response.data;
            this.userPhotoUrl = response.data.photo_url;
          })
          .catch(error => {
            console.log(error);
          });
    },
    history(id) {
      axios.get(`http://localhost:8000/api/history/${id}`, {
        headers:{
          'Authorization': `Bearer ${localStorage.getItem('access_token')}`
        }
      })
          .then(response => {
            this.historyData = response.data;
          })
    },
    handleFileChange(event) {
      this.selectedFile = event.target.files[0]; // Сохраняем выбранный файл
    },
    uploadPhoto() {
      if (!this.selectedFile) {
        alert("Please select a photo to upload!");
        return;
      }

      const formData = new FormData();
      formData.append("photo", this.selectedFile); // Добавляем фото в FormData

      axios.post('http://localhost:8000/api/user/upload-photo', formData, {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
          'Content-Type': 'multipart/form-data',
        }
      })
          .then(response => {
            console.log('Access token in localStorage:', localStorage.getItem('access_token'));

            alert("Photo uploaded successfully!");
            this.userPhotoUrl = `http://localhost/storage/${response.data.photo}`; // Обновляем URL после загрузки
          })
          .catch(error => {
            console.log("Failed to upload photo:", error);
          });
    }
  },
  mounted() {
    this.getInfo();
  }
}
</script>

<template>
  <div v-if="userData" class="user-info">
    <h3>Name: {{ userData.name }}</h3>
    <h3>Email: {{ userData.email }}</h3>
    <h3>Role: {{ userData.role }}</h3>
  </div>

  <div v-if="userPhotoUrl" class="photo-section">
    <h3>User Photo:</h3>
    <img :src="userPhotoUrl" alt="User Photo" class="user-photo" />
  </div>

  <div class="upload-section">
    <h3>Upload New Photo:</h3>
    <input type="file" @change="handleFileChange" />
    <button @click="uploadPhoto" class="upload-button">Upload Photo</button>
  </div>

  <button @click="history(userData.id)" class="history-button">Purchases History</button>

  <div v-if="historyData" class="history-table-container">
    <table class="history-table">
      <thead>
      <tr>
        <th>Number</th>
        <th>Quantity</th>
        <th>Service Name</th>
        <th>Status</th>
        <th>Create Time</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(data, index) in historyData" :key="data.id">
        <td>{{ index + 1 }}</td>
        <td>{{ data.quantity }}</td>
        <td>{{ data.service.name }}</td>
        <td>{{ data.status }}</td>
        <td>{{ new Date(data.created_at).toLocaleString() }}</td>

      </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
/* User Info Section */
.user-info {
  background-color: #f9f9f9;
  padding: 20px;
  border-radius: 8px;
  margin-bottom: 20px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.user-info h3 {
  font-size: 18px;
  color: #333;
  margin: 5px 0;
}

.photo-section {
  margin-bottom: 20px;
}

.user-photo {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  object-fit: cover;
  margin: 10px 0;
}

.upload-section {
  margin-bottom: 20px;
}

.upload-button {
  background-color: #007bff;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
  margin-top: 10px;
}

.upload-button:hover {
  background-color: #0056b3;
}

.history-button {
  background-color: #ff9f00;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
  margin-bottom: 20px;
}

.history-button:hover {
  background-color: #e68900;
}

/* Table Section */
.history-table-container {
  overflow-x: auto;
}

.history-table {
  width: 100%;
  border-collapse: collapse;
  margin: 20px 0;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.history-table th, .history-table td {
  padding: 12px 15px;
  text-align: left;
}

.history-table thead {
  background-color: #f1f1f1;
}

.history-table th {
  font-weight: bold;
  color: #444;
}

.history-table tr:nth-child(even) {
  background-color: #f9f9f9;
}

.history-table tr:hover {
  background-color: #f2f2f2;
}

.history-table td {
  border-bottom: 1px solid #ddd;
}
</style>
