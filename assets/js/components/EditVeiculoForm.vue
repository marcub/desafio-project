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
              v-model="veiculo.nomeDoProprietario"
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
      <b-row class="mt-4" style="justify-content: space-between;">
        <b-col cols="3">
          <b-button variant="primary" class="px-5" @click="updateVeiculo"
            >Atualizar veículo</b-button
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
    name: "EditVeiculoModal",
    props: {
      veiculoId: Number,
    },
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
    mounted() {
      this.getVeiculoByID();
    },
    methods: {
      triggerClose() {
        this.$emit("closeEditVeiculoModal");
      },
      getVeiculoByID() {
        axios
          .get(`http://localhost:8000/veiculos/${this.veiculoId}`)
          .then((response) => {
            this.veiculo = response.data;
          })
          .catch((error) => {
            console.log(error);
          });
      },
      updateVeiculo() {
        axios
          .put(
            `http://localhost:8000/veiculos/update/${this.veiculoId}`,
            this.veiculo
          )
          .then((response) => {
            console.log(response.data);
            this.$emit("closeEditVeiculoModal");
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