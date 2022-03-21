<script>
import { computed } from '@vue/runtime-core'
import { RouterLink, RouterView } from 'vue-router'

export default {
  data() {
    return {
      shops: {
        bike: {
          title: "Velo Werkstatt",
          image: "velo",
          isActive: false,
        },
        wood: {
          title: "Holz Werkstatt",
          image: "holz",
          isActive: false,

        },
        pottery: {
          title: "Ton Werkstatt",
          image: "ton",
          isActive: false,

        },
        digital: {
          title: "Digital Werkstatt",
          image: "digital",
          isActive: false,

        },
        textile: {
          title: "Textil Atelier",
          image: "textil",
          isActive: false,

        },
        screenPrint: {
          title: "Siebdruck Atelier",
          image: "siebdruck",
          isActive: false,
        }
      }
    }
  },
  props: {
    userId: String
  },
methods: {
  checkout() {
    // send data to db
    // 
  },
},
computed: {
  shopSelected() {
    return this.shops.bike.isActive || 
        this.shops.wood.isActive || 
        this.shops.pottery.isActive || 
        this.shops.digital.isActive || 
        this.shops.textile.isActive || 
        this.shops.screenPrint.isActive;
  }
},
}

</script>

<template>
  <div class="shops">
  </div>
  <h5 class="shops-title">Welche Werkstatt hast du heute genutzt?</h5>
  <div class="shop-panels">
    <div v-for="(shop, key, index) in shops" :key="index">
      <div class="shop-panel" :class="{ active: false }">
        <label class="shop-panel-container" :class="{ checked: shops[key].isActive }">
            <img class="shop-panel-bg" :src="'./src/assets/' + shops[key].image + '.jpeg'"/>
            <input type="checkbox" :id="key" v-model="shops[key].isActive">
        </label>
      </div>
    </div>
    <div class="submit">
      <button @click="checkout" class="button button-primary" :disabled="!shopSelected">Weiter</button>
    </div>
  </div>
</template>

<style scoped>
  .shops-title {
    text-align: center;
    margin-top: 40px;
    margin-bottom: 10px;
  }

  .shop-panels {
    padding: 0 150px;
    padding-top: 20px;
    display: grid;
    grid-template-columns: repeat(3, auto [col-start]);
    grid-template-rows: auto [row-start] auto [row-start] 50px [row-start];
    justify-items: center;
}
 .submit {
   grid-column-start: 3;
   grid-row-start: 5;
 }

/* The checkbox container */

.shop-panel-bg {
  width: 150px;
  border-radius: 50%;
  opacity: 0.5;
  filter: grayscale(100%);
}

.shop-panel-container {
  display: block;
  position: relative;
  cursor: pointer;
  font-size: 22px;
  border: black 1px solid;
  padding: 9px;
  border-radius: 50%;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.shop-panel-container.checked {
    border: var(--macherschaft-blue) 10px solid;
    padding: 0;
}
.shop-panel-container.checked img{
  opacity: 1;
  filter: grayscale(0%);
}
/* Hide the browser's default checkbox */
.shop-panel-container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

</style>
