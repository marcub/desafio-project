<template>
    <div>
      <b-row class="mt-2 mb-3">
        <h6 class="text-secondary">
          Tem certeza que deseja deletar o veículo?
        </h6>
      </b-row>
      <b-row class="mt-2 mb-3">
        <p class="text-danger">
          Essa ação não é reversível e pode causar perca importante de dados.
        </p>
      </b-row>
      <b-row class="mt-4">
        <b-col>
          <b-button variant="danger" @click="removeVeiculoFromData"
            >Deletar veículo</b-button
          >
        </b-col>
        <b-col>
          <b-button variant="danger" @click="triggerClose">Fechar</b-button>
        </b-col>
      </b-row>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    name: "DeleteVeiculoModal",
    props: {
      veiculoId: Number,
    },
    methods: {
      triggerClose() {
        this.$emit("closeDeleteVeiculoModal");
      },
      removeVeiculoFromData() {
        axios
          .delete(`http://localhost:8000/veiculos/remove/${this.veiculoId}`)
          .then(() => {
            this.$emit("reloadDataTable");
            this.$emit("showDeleteAlert");
            this.$emit("closeDeleteVeiculoModal");
          })
          .catch((error) => {
            console.log(error);
          });
      },
    },
  };
  </script>