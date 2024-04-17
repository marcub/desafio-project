<template>
    <div>
      <b-row>
        <b-alert v-model="showSuccessAlert" variant="success" dismissible>
          {{ alertMessage }}
        </b-alert>
      </b-row>
      <b-row>
        <overview
            :totalMotoristas="numeroDeMotoristas"
            :totalVeiculos="numeroDeVeiculos"
            @totalMotoristaIsActive="setFilterMotoristaIsActive"
            @totalVeiculosIsActive="setFilterVeiculoIsActive"
        ></overview>
      </b-row>
      <b-row class="mt-3">
        <b-card>
          <b-row align-h="between">
            <b-col cols="6">
              <h3>{{ tableHeader }}</h3>
            </b-col>
            <b-col cols="2">
              <b-row>
                <b-col>
                  <b-button
                    variant="primary"
                    id="show-btn"
                    @click="showCreateModal"
                  >
                    <b-icon-plus class="text-white"></b-icon-plus>
                    <span class="h6 text-white">Novo motorista</span>
                  </b-button>
                </b-col>
              </b-row>
            </b-col>
          </b-row>
          <b-row class="mt-3">
            <b-table
              striped
              hover
              :items="items"
              :fields="fields"
              class="text-center"
            >
              <template #cell(actions)="data">
                <b-row>
                  <b-col cols="7">
                    <b-icon-pencil-square
                      class="action-item"
                      variant="primary"
                      @click="getRowData(data.item.id)"
                    ></b-icon-pencil-square>
                  </b-col>
                  <b-col cols="1">
                    <b-icon-trash-fill
                      class="action-item"
                      variant="danger"
                      @click="showDeleteModal(data.item.id)"
                    ></b-icon-trash-fill>
                  </b-col>
                </b-row>
              </template>
            </b-table>
          </b-row>
        </b-card>
      </b-row>
  
      <!-- Modal for adding new customers -->
      <b-modal
        ref="create-motorista-modal"
        size="xl"
        hide-footer
        title="New Customer"
      >
        <create-motorista-form
          @closeCreateModal="closeCreateModal"
          @reloadDataTable="getMotoristaData"
          @showSuccessAlert="showAlertCreate"
        ></create-motorista-form>
      </b-modal>
  
      <!-- Modal for updating customers -->
      <b-modal
        ref="edit-customer-modal"
        size="xl"
        hide-footer
        title="Edit Customer"
      >
        <edit-customer-form
          @closeEditModal="closeEditModal"
          @reloadDataTable="getMotoristaData"
          @showSuccessAlert="showAlertUpdate"
          :motoristaId="motoristaId"
        ></edit-customer-form>
      </b-modal>
  
      <!-- Delete Customer Modal -->
      <b-modal
        ref="delete-customer-modal"
        size="md"
        hide-footer
        title="Confirm Deletion"
      >
        <delete-customer-modal
          @closeDeleteModal="closeDeleteModal"
          @reloadDataTable="getMotoristaData"
          @showDeleteAlert="showDeleteSuccessModal"
          :motoristaId="motoristaId"
        ></delete-customer-modal>
      </b-modal>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  import Overview from "./Overview.vue";
  import CreateMotoristaForm from "./CreateMotoristaForm.vue";
  //import EditMotoristaForm from "./EditMotoristaForm.vue";
  //import DeleteMotoristaModal from "./DeleteMotoristaModal.vue";
  
  export default {
    components: {
      Overview,
      CreateCustomerForm,
      //EditCustomerForm,
      //DeleteCustomerModal,
    },
    data() {
      return {
  
        fields: [
          {
            key: "nome",
            label: "Nome",
            sortable: false,
          },
          {
            key: "cpf",
            label: "CPF",
            sortable: false,
          },
          {
            key: "rg",
            label: "RG",
            sortable: false,
          },
          {
            key: "dataNascimento",
            label: "Data de Nascimento",
            sortable: false,
          },
          "actions",
        ],
        items: [],
        numeroDeMotoristas: 0,
        numeroDeVeiculos: 0,
        motoristaId: 0,
        veiculoId: 0,
        companySearchTerm: "",
        tableHeader: "",
        showSuccessAlert: false,
        alertMessage: "",
      };
    },
    mounted() {
      this.getMotoristaData();
    },
    methods: {
      showCreateModal() {
        this.$refs["create-motorista-modal"].show();
      },
      closeCreateModal() {
        this.$refs["create-motorista-modal"].hide();
      },
      getMotoristaData() {
        axios
          .get("http://localhost:8000/motoristas/")
          .then((response) => {
            this.tableHeader = "Total de motoristas";
            this.items = response.data;
            this.numeroDeMotoristas = response.data.length;
          })
          .catch((error) => {
            console.log(error);
          });
      },
      getVeiculoData() {
        axios
          .get("http://localhost:8000/veiculos/")
          .then((response) => {
            this.fields = [
                {
                    key: "crlv",
                    label: "CRLV",
                    sortable: false,
                },
                {
                    key: "nomeDoProprietario",
                    label: "Nome do Proprietário",
                    sortable: false,
                },
                {
                    key: "tipo",
                    label: "Tipo",
                    sortable: false,
                },
                {
                    key: "createdAt",
                    label: "Data de criação",
                    sortable: false,
                },
                "actions",
            ];
            this.tableHeader = "Total de veículos";
            this.items = response.data;
            this.numeroDeVeiculos = response.data.length;
          })
          .catch((error) => {
            console.log(error);
          });
      },
      getRowData(id) {
        this.$refs["edit-customer-modal"].show();
        this.motoristaId = id;
      },
      closeEditModal() {
        this.$refs["edit-customer-modal"].hide();
      },
      setFilterMotoristaIsActive() {
        this.tableHeader = "Total de motoristas";
        this.getMotoristaData();
      },
      setFilterVeiculoIsActive() {
        this.tableHeader = "Total de veículos";
        this.getVeiculoData();
      },
      showAlertCreate() {
        this.showSuccessAlert = true;
        this.alertMessage = "Motorista foi criado com sucessa";
      },
      showAlertUpdate() {
        this.showSuccessAlert = true;
        this.alertMessage = "Motorista foi atualizado com sucesso";
      },
      showDeleteModal(id) {
        this.$refs["delete-customer-modal"].show();
        this.motoristaId = id;
      },
      closeDeleteModal() {
        this.$refs["delete-customer-modal"].hide();
      },
      showDeleteSuccessModal() {
        this.showSuccessAlert = true;
        this.alertMessage = "Motorista foi deletado com sucesso!";
      },
    },
  };
  </script>
  
  <style>
  .action-item:hover {
    cursor: pointer;
  }
  </style>