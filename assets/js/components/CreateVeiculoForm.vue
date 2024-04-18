<template>
    <b-form class="mt-3">
      <b-row>
        <b-row>
          <h4 class="text-secondary">Informações</h4>
        </b-row>
        <b-col cols="6">
          <b-form-group id="nomeProprietario" label="Nome do Proprietario" label-for="nomeProprietario">
            <b-form-input
              id="nomeProprietario"
              type="text"
              placeholder="Nome do Proprietario"
              v-model="veiculo.nomeProprietario"
            ></b-form-input>
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group id="crlv" label="CRLV" label-for="crlv">
            <b-form-input
              id="crlv"
              type="text"
              placeholder="CRLV"
              v-model="veiculo.crlv"
            ></b-form-input>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row class="mt-3">
        <b-col cols="6">
          <b-form-group id="tipo" label="Tipo" label-for="tipo">
            <b-form-select
              id="tipo"
              v-model="veiculo.tipo"
              :options="options"
            ></b-form-select>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row class="mt-4">
        <b-col cols="3">
          <b-button variant="primary" class="px-5" @click="addNewVeiculo"
            >Criar Veiculo</b-button
          >
        </b-col>
        <b-col>
          <b-button variant="warning" @click="triggerClose">Close</b-button>
        </b-col>
      </b-row>
    </b-form>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    name: "CreateVeiculoModal",
    data() {
      return {
        veiculo: {},
        options: [
        'Caminhões Leves', 
        'Caminhões Pesados', 
        'Veículos de Carga Especializada', 
        'Veículos de Entrega Expressa', 
        'Veículos de Transporte Intermodal', 
        'Veículos Autônomos'
        ]
      };
    },
    methods: {
      triggerClose() {
        this.$emit("closeCreateVeiculoModal");
      },
      addNewVeiculo() {
        axios
          .post("http://localhost:8000/veiculos/create", this.veiculo)
          .then((response) => {
            console.log(response.data);
            this.$emit("closeCreateVeiculoModal");
            this.$emit("reloadDataTable");
            this.$emit("showSuccessAlert");
          })
          .catch((error) => {
            console.log(error);
          });
      },
    },
  };
  </script>