<script>
import axios from "axios";

export default {
  props: {
    id: {
      required: true
    }
  },
  data() {
    return {
      services: [],
      name: '',
      description: '',
      price: '',
      updatedName: '',
      updatedDescription: '',
      updatedPrice: null,
      editMode: null
    }
  },
  methods: {
    getDetailCategory(id) {
      axios.get(`http://localhost:8000/api/categories/${id}`, {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('access_token')}`
        }
      }).then(response => {
            this.services = response.data[3]
          }
      )
    },
    storeService() {
      axios.post('http://localhost:8000/api/services', {
        'name': this.name,
        'description': this.description,
        'price': this.price,
        'category_id': this.id
      }, {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('access_token')}`
        }
      })
    },
    editService(id) {
      axios.put(`http://localhost:8000/api/services/${id}`, {
        'name': this.updatedName,
        'description': this.updatedDescription,
        'category_id': this.id,
        'price': this.updatedPrice
      }, {
        headers:{
          'Authorization': `Bearer ${localStorage.getItem('access_token')}`
        }
      })
          .then(request => {
            console.log("Request: ", request);
            this.updatedName = '',
                this.updatedDescription = '',
                this.updatedPrice = '',
                this.getDetailCategory(this.id)
          }).catch(error => {
        console.log(error);
      })
    },
    openEdit(id) {
      this.editMode = this.editMode === id ? null : id
    }
  },
  mounted() {
    if (this.id) {
      this.getDetailCategory(this.id)
    } else {
      console.error('No ID')
    }
  }
}
</script>

<template>
  <div class="container">
    <h2 class="text-center">Manage Services</h2>

    <div v-for="service in services" :key="service.id" class="card mb-3">
      <div class="card-body">
        <h3 class="card-title">{{ service.name }}</h3>
        <p class="card-text">{{ service.description }}</p>
        <button @click="openEdit(service.id)" class="btn btn-warning">Edit</button>

        <div v-if="editMode === service.id" class="mt-3">
          <input type="text" v-model="updatedName" placeholder="Name" class="form-control mb-2">
          <input type="text" v-model="updatedDescription" placeholder="Description" class="form-control mb-2">
          <input type="number" v-model="updatedPrice" placeholder="Price" class="form-control mb-2">
          <button @click="editService(service.id)" class="btn btn-success">Save Changes</button>
        </div>
      </div>
    </div>

    <div class="card p-3">
      <h3>Add Service</h3>
      <input v-model="name" type="text" placeholder="Enter service" class="form-control mb-2">
      <input v-model="description" type="text" placeholder="Enter description" class="form-control mb-2">
      <input v-model="price" type="number" placeholder="Enter price" class="form-control mb-2">
      <button @click="storeService" class="btn btn-primary">Add Service</button>
    </div>
  </div>
</template>

<style scoped>
.container {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

h2 {
  text-align: center;
  margin-bottom: 20px;
}

.card {
  background: #f8f9fa;
  padding: 15px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card-title {
  font-size: 18px;
  font-weight: bold;
  color: #343a40;
}

.btn {
  padding: 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background 0.3s;
}

.btn-primary {
  background: #007bff;
  color: white;
}

.btn-primary:hover {
  background: #0056b3;
}

.btn-warning {
  background: #ffc107;
  color: black;
}

.btn-warning:hover {
  background: #e0a800;
}

.btn-success {
  background: #28a745;
  color: white;
}

.btn-success:hover {
  background: #218838;
}
</style>
