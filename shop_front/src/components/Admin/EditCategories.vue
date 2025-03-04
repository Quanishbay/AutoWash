<script>
import axios from "axios";

export default {
  data() {
    return {
      data: '',
      categoryName: '',
      description: '',
      editMode: false
    };
  },
  methods: {
    addCategory() {
      axios.post('http://localhost:8000/api/categories', {
        'name': this.categoryName,
        'description': this.description
      }).then(() => {
        this.categoryName = '';
        this.description = '';
        this.getCategories();
      });
    },

    getCategories() {
      axios.get('http://localhost:8000/api/categories', {
        headers:{
          'Authorization': `Bearer ${localStorage.getItem('access_token')}`
        }
      })
          .then(response => this.data = response.data);
    },

    deleteCategory(id) {
      axios.delete(`http://localhost:8000/api/categories/${id}`)
          .then(this.getCategories);
    },

    editCategory(id) {
      axios.put(`http://localhost:8000/api/categories/${id}`, {
        'name': this.categoryName,
        'description': this.description
      }).then(() => {
        this.categoryName = '';
        this.description = '';
        this.getCategories();
      });
    },

    isEdit(id) {
      this.editMode = this.editMode === id ? null : id;
    }
  },
  mounted() {
    this.getCategories();
  }
};
</script>

<template>
  <div class="container">
    <h2>Manage Categories</h2>

    <div class="form-group">
      <input type="text" v-model="categoryName" placeholder="Category name" class="input-field">
      <input type="text" v-model="description" placeholder="Description" class="input-field">
      <button @click="addCategory()" class="btn btn-primary">Add Category</button>
    </div>

    <div v-for="item in data" :key="item.id" class="category-card">
      <div class="category-header">
        <router-link :to="`/edit/services/${item.id}`" class="category-title">{{ item.name }}</router-link>
        <div>
          <button @click="deleteCategory(item.id)" class="btn btn-danger">Delete</button>
          <button @click="isEdit(item.id)" class="btn btn-edit">Edit</button>
        </div>
      </div>
      <p class="category-description">{{ item.description }}</p>

      <div v-if="editMode === item.id" class="edit-form">
        <input v-model="categoryName" type="text" placeholder="Name" class="input-field">
        <input v-model="description" type="text" placeholder="Description" class="input-field">
        <button @click="editCategory(item.id)" class="btn btn-update">Update Category</button>
      </div>
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

.form-group {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.input-field {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
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

.btn-danger {
  background: #dc3545;
  color: white;
}

.btn-danger:hover {
  background: #c82333;
}

.btn-edit {
  background: #28a745;
  color: white;
}

.btn-edit:hover {
  background: #218838;
}

.btn-update {
  background: #ffc107;
  color: black;
}

.btn-update:hover {
  background: #e0a800;
}

.category-card {
  background: #f8f9fa;
  padding: 15px;
  border-radius: 8px;
  margin-top: 15px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.category-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.category-title {
  font-size: 18px;
  font-weight: bold;
  color: #007bff;
}

.category-description {
  color: #6c757d;
  margin-top: 5px;
}

.edit-form {
  margin-top: 10px;
  padding: 10px;
  background: white;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
</style>
