<template>
    <b-form class="mt-3">
      <b-row>
        <b-row>
          <h4 class="text-secondary">Informações pessoais</h4>
        </b-row>
        <b-col cols="6">
          <b-form-group id="nome" label="Nome" label-for="nome">
            <b-form-input
              id="nome"
              type="text"
              placeholder="Nome"
              v-model="motorista.nome"
            ></b-form-input>
          </b-form-group>
        </b-col>
        <b-col cols="6">
          <b-form-group id="cpf" label="CPF" label-for="cpf">
            <b-form-input
              id="cpf"
              type="text"
              placeholder="CPF"
              v-model="motorista.cpf"
            ></b-form-input>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row class="mt-3">
        <b-col cols="6">
          <b-form-group id="rg" label="RG" label-for="rg">
            <b-form-input
              id="rg"
              type="rg"
              placeholder="RG"
              v-model="motorista.rg"
            ></b-form-input>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row class="mt-5">
        <h4 class="text-secondary">Carteira Nacional de Habilitação (CNH)</h4>
      </b-row>
      <b-row>
        <b-col cols="4">
          <b-form-group
            id="numero"
            label="Número"
            label-for="numero"
          >
            <b-form-input
              id="numero"
              type="text"
              placeholder="Número"
              v-model="motorista.numero"
            ></b-form-input>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols="4">
          <b-form-group
            id="validade"
            label="Validade"
            label-for="validade"
          >
            <b-form-input
              id="validade"
              type="date"
              v-model="motorista.validade"
            ></b-form-input>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row class="mt-2">
        <b-form-group
            id="tipo"
            label="Tipo"
            label-for="tipo"
          >
            <b-form-input
              id="tipo"
              type="text"
              placeholder="Tipo"
              v-model="motorista.tipo"
            ></b-form-input>
          </b-form-group>
      </b-row>
      <b-row class="mt-4">
        <b-col cols="3">
          <b-button variant="primary" class="px-5" @click="addNewMotorista"
            >Criar Motorista</b-button
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
    name: "CreateCustomerModal",
    data() {
      return {
        motorista: {},
      };
    },
    methods: {
      triggerClose() {
        this.$emit("closeCreateModal");
      },
      addNewMotorista() {
        axios
          .post("http://localhost:8000/motoristas/create", this.motorista)
          .then((response) => {
            console.log(response.data);
            this.$emit("closeCreateModal");
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