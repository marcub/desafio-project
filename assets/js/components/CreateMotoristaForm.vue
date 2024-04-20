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
              type="text"
              placeholder="RG"
              v-model="motorista.rg"
            ></b-form-input>
          </b-form-group>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols="4">
          <b-form-group
            id="dataNascimento"
            label="Data de Nascimento"
            label-for="dataNascimento"
          >
            <b-form-input
              id="dataNascimento"
              type="date"
              v-model="motorista.dataNascimento"
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
            id="cnh"
            label="Número"
            label-for="cnh"
          >
            <b-form-input
              id="cnh"
              type="text"
              placeholder="Número"
              v-model="motorista.cnh"
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
        <b-form-group id="categoria" label="Categoria" label-for="categoria">
            <b-form-select
              id="categoria"
              v-model="motorista.categoria"
              :options="options"
            ></b-form-select>
          </b-form-group>
      </b-row>
      <b-row class="mt-4" style="justify-content: space-between;">
        <b-col cols="3">
          <b-button variant="primary" class="px-5" @click="addNewMotorista"
            >Criar Motorista</b-button
          >
        </b-col>
        <b-col cols="1">
          <b-button variant="danger" @click="triggerClose">Fechar</b-button>
        </b-col>
      </b-row>
    </b-form>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    name: "CreateMotoristaModal",
    data() {
      return {
        motorista: {},
        options: [
          'A', 
          'B', 
          'C', 
          'D', 
          'E'
        ]
      };
    },
    methods: {
      triggerClose() {
        this.$emit("closeCreateMotoristaModal");
      },
      addNewMotorista() {
        axios
          .post("http://localhost:8000/motoristas/create", this.motorista)
          .then((response) => {
            console.log(response.data);
            this.$emit("closeCreateMotoristaModal");
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