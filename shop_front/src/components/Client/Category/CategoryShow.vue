<script>
import axios from "axios";

export default {
  props: ["id"],
  data() {
    return {
      categories: null,
    };
  },
  methods: {
    getCategoryDetail() {
      axios.get(`http://localhost:8000/api/categories/${this.id}`, {
        headers:{
          'Authorization': `Bearer ${localStorage.getItem('access_token')}`
        }
      })
          .then(response => {
            this.categories = response.data[3];
          });
    },
    addToCart(category) {
      const request_data = {
        service_id: category.id,
        quantity: 1,
        total: parseInt(category.price, 10),
        status: "active",
        category_id: this.id,
      };
      console.log(request_data);

      axios.post("http://localhost:8000/api/carts", request_data, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("access_token")}`,
        },
      })
          .then(response => {
            console.log(response);
          })
          .catch(error => {
            console.log(error);
          });
    },
  },
  mounted() {
    this.getCategoryDetail();
  },
};
</script>

<template>
  <div class="container">
    <div v-if="categories" class="categories-grid">
      <div v-for="category in categories" :key="category.id" class="category-card">
        <h3 class="category-title">{{ category.name }}</h3>
        <p class="category-description">{{ category.description }}</p>
        <button @click="addToCart(category)" class="add-to-cart-btn">Add to cart</button>
      </div>
    </div>
    <div v-else class="loading">
      <p>Loading...</p>
    </div>
  </div>
</template>

<style scoped>
/* Основной контейнер */
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f4f4f4;
  padding: 20px;
}

/* Грид для категорий */
.categories-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  max-width: 1200px;
  width: 100%;
}

/* Карточка категории */
.category-card {
  background: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s, box-shadow 0.3s;
}

.category-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

/* Заголовок */
.category-title {
  font-size: 1.2rem;
  font-weight: bold;
  color: #333;
}

/* Описание */
.category-description {
  font-size: 0.9rem;
  color: #666;
  margin-top: 5px;
}

/* Кнопка */
.add-to-cart-btn {
  display: inline-block;
  margin-top: 10px;
  padding: 10px 15px;
  background-color: #c0392b;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1rem;
  transition: background 0.3s, transform 0.2s;
}

.add-to-cart-btn:hover {
  background-color: #a93226;
  transform: scale(1.05);
}

/* Индикатор загрузки */
.loading {
  font-size: 1.2rem;
  color: #555;
  animation: pulse 1.5s infinite;
}

/* Анимация загрузки */
@keyframes pulse {
  0% { opacity: 0.6; }
  50% { opacity: 1; }
  100% { opacity: 0.6; }
}
</style>
