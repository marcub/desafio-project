<template>
    <div>
      <b-row class="text-center">
        <b-col>
          <div
            class="filter-card p-3"
            :class="{
              'bg-active-filter': motoristaIsActive,
              'bg-light': !motoristaIsActive,
            }"
            @click="totalMotoristasIsActiveFilter"
          >
            <h6>Total de motoristas</h6>
            <h4>
              <strong>{{ totalMotoristas }}</strong>
            </h4>
          </div>
        </b-col>
        <b-col>
          <div
            class="filter-card p-3"
            :class="{
              'bg-active-filter': veiculoIsActive,
              'bg-light': !veiculoIsActive,
            }"
            @click="totalVeiculosIsActiveFilter"
          >
            <h6 class="text-secondary">Total de veículos</h6>
            <h4>
              <strong>{{ totalVeiculos }}</strong>
            </h4>
          </div>
        </b-col>
      </b-row>
    </div>
  </template>
  
  <script>
  export default {
    name: "Overview",
    props: {
      totalMotoristas: Number,
      totalVeiculos: Number,
    },
    data() {
      return {
        motoristaIsActive: true,
        veiculoIsActive: false,
      };
    },
    methods: {
      totalMotoristasIsActiveFilter() {
        this.motoristaIsActive = true;
        this.veiculoIsActive = false;
        this.$emit("totalMotoristaIsActive");
      },
      totalVeiculosIsActiveFilter() {
        this.motoristaIsActive = false;
        this.veiculoIsActive = true;
        this.$emit("totalVeiculosIsActive");
      },
    },
  };
  </script>
  
  <style>
  .filter-card:hover {
    cursor: pointer;
    text-decoration: underline;
  }
  
  .bg-active-filter {
    background-color: #e9f1fe;
    color: #074297;
  }
  </style>