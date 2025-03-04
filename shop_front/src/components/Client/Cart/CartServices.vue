<script>
import axios from "axios";

export default {
  data() {
    return {
      cartItems: null,
    }
  },
  methods: {
    getCartItems() {
      axios.get('http://localhost:8000/api/carts/', {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('access_token')}`
        }
      }).then(response => {
            console.log(response.data);
            this.cartItems = response.data
            console.log(this.cartItems);


          }
      )
    },
    deleteCart(id) {
      axios.delete(`http://localhost:8000/api/carts/${id}`, {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('access_token')}`
        }
      }).then(() => {
        this.getCartItems()
      }).catch((error) => {
        console.log(error);
      })
    },
    updateCart(item) {
      axios.put(`http://localhost:8000/api/carts/${item.id}`, {
            'quantity': item.quantity,
            'total': item.quantity * item.service.price,
          }, {
        headers:{
          'Authorization': `Bearer ${localStorage.getItem('access_token')}`
        }
          }
      ).then(() => {
        this.getCartItems()
        console.log(this.item);
      })
    },
    submitCart(items) {
      axios.put(`http://localhost:8000/api/submit`, items, {
        headers:{
          'Authorization': `Bearer ${localStorage.getItem('access_token')}`
        }

      }).then(() => {
        this.getCartItems()
      })
          .catch(error => {
            console.log(this.cartItems);
            console.log(error);
          })
    }
  },
  mounted() {
    this.getCartItems()

  }
}
</script>

<template>
  <table class="min-w-full table-auto border-collapse">
    <thead>
    <tr class="bg-gray-200">
      <th class="px-4 py-2 border">Service Name</th>
      <th class="px-4 py-2 border">Status</th>
      <th class="px-4 py-2 border">Quantity</th>
      <th class="px-4 py-2 border">Total</th>
      <th class="px-4 py-2 border">Actions</th>
    </tr>
    </thead>
    <tbody>

    <tr v-for="item in cartItems" :key="item.id">
      <td class="px-4 py-2 border">{{ item.service.name }}</td>
      <td class="px-4 py-2 border">{{ item.status }}</td>
      <td class="px-4 py-2 border">
        <input v-model.number="item.quantity" type="number" class="px-4 py-2 border" min="1" @click="updateCart(item)">
      </td>
      <td class="px-4 py-2 border">{{ item.total }}</td>
      <td class="px-4 py-2 border">
        <button @click="deleteCart(item.id)" class="bg-red-500 text-white py-1 px-3 rounded">Delete</button>
      </td>
    </tr>

    </tbody>
  </table>
  <button @click="submitCart(cartItems)">Submit</button>

</template>


<style scoped>

</style>