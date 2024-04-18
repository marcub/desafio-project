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
                    @click="showCreateMotoristaModal"
                  >
                    <b-icon-plus class="text-white"></b-icon-plus>
                    <span class="h6 text-white">Novo motorista</span>
                  </b-button>
                </b-col>
              </b-row>
            </b-col>
            <b-col cols="2">
              <b-row>
                <b-col>
                  <b-button
                    variant="primary"
                    id="show-btn"
                    @click="showCreateVeiculoModal"
                  >
                    <b-icon-plus class="text-white"></b-icon-plus>
                    <span class="h6 text-white">Novo veículo</span>
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
                      @click="getRowMotoristaData(data.item.id)"
                    ></b-icon-pencil-square>
                  </b-col>
                  <b-col cols="1">
                    <b-icon-trash-fill
                      class="action-item"
                      variant="danger"
                      @click="showDeleteMotoristaModal(data.item.id)"
                    ></b-icon-trash-fill>
                  </b-col>
                </b-row>
              </template>
            </b-table>
          </b-row>
        </b-card>
      </b-row>
  
      <!-- Modal for adding new drivers -->
      <b-modal
        ref="create-motorista-modal"
        size="xl"
        hide-footer
        title="Novo Motorista"
      >
        <create-motorista-form
          @closeCreateMotoristaModal="closeCreateMotoristaModal"
          @reloadDataTable="getMotoristaData"
          @showSuccessAlert="showAlertMotoristaCreate"
        ></create-motorista-form>
      </b-modal>

      <!-- Modal for adding new vehicles -->
      <b-modal
        ref="create-veiculo-modal"
        size="xl"
        hide-footer
        title="Novo Veículo"
      >
        <create-veiculo-form
          @closeCreateVeiculoModal="closeCreateVeiculoModal"
          @reloadDataTable="getVeiculoData"
          @showSuccessAlert="showAlertVeiculoCreate"
        ></create-veiculo-form>
      </b-modal>
  
      <!-- Modal for updating drivers -->
      <b-modal
        ref="edit-motorista-modal"
        size="xl"
        hide-footer
        title="Editar Motorista"
      >
        <edit-motorista-form
          @closeEditMotoristaModal="closeEditMotoristaModal"
          @reloadDataTable="getMotoristaData"
          @showSuccessAlert="showAlertMotoristaUpdate"
          :motoristaId="motoristaId"
        ></edit-motorista-form>
      </b-modal>

      <!-- Modal for updating vehicles -->
      <b-modal
        ref="edit-veiculo-modal"
        size="xl"
        hide-footer
        title="Editar Veículo"
      >
        <edit-veiculo-form
          @closeEditVeiculoModal="closeEditVeiculoModal"
          @reloadDataTable="getVeiculoData"
          @showSuccessAlert="showAlertVeiculoUpdate"
          :veiculoId="veiculoId"
        ></edit-veiculo-form>
      </b-modal>
  
      <!-- Delete Driver Modal -->
      <b-modal
        ref="delete-motorista-modal"
        size="md"
        hide-footer
        title="Confirmação"
      >
        <delete-motorista-modal
          @closeDeleteMotoristaModal="closeDeleteMotoristaModal"
          @reloadDataTable="getMotoristaData"
          @showDeleteAlert="showDeleteMotoristaSuccessModal"
          :motoristaId="motoristaId"
        ></delete-motorista-modal>
      </b-modal>

      <!-- Delete Vehicle Modal -->
      <b-modal
        ref="delete-veiculo-modal"
        size="md"
        hide-footer
        title="Confirmação"
      >
        <delete-veiculo-modal
          @closeDeleteVeiculoModal="closeDeleteVeiculoModal"
          @reloadDataTable="getVeiculoData"
          @showDeleteAlert="showDeleteVeiculoSuccessModal"
          :veiculoId="veiculoId"
        ></delete-veiculo-modal>
      </b-modal>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  import Overview from "./Overview.vue";
  import CreateMotoristaForm from "./CreateMotoristaForm.vue";
  import CreateVeiculoForm from "./CreateVeiculoForm.vue";
  import EditMotoristaForm from "./EditMotoristaForm.vue";
  //import DeleteMotoristaModal from "./DeleteMotoristaModal.vue";
  
  export default {
    components: {
      Overview,
      CreateMotoristaForm,
      CreateVeiculoForm,
      EditMotoristaForm,
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
      showCreateMotoristaModal() {
        this.$refs["create-motorista-modal"].show();
      },
      showCreateVeiculoModal() {
        this.$refs["create-veiculo-modal"].show();
      },
      closeCreateMotoristaModal() {
        this.$refs["create-motorista-modal"].hide();
      },
      closeCreateVeiculoModal() {
        this.$refs["create-veiculo-modal"].hide();
      },
      getMotoristaData() {
        axios
          .get("http://localhost:8000/motoristas/")
          .then((response) => {
            this.fields = [
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
            ];
            this.tableHeader = "Total de motoristas";
            this.items = response.data;
            this.numeroDeMotoristas = response.data.length;
          })
          .catch((error) => {
            console.log(error);
          });

          axios
          .get("http://localhost:8000/veiculos/")
          .then((response) => {
            this.numeroDeVeiculos = response.data.length;
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
      getRowMotoristaData(id) {
        this.$refs["edit-motorista-modal"].show();
        this.motoristaId = id;
      },
      getRowVeiculoData(id) {
        this.$refs["edit-veiculo-modal"].show();
        this.veiculoId = id;
      },
      closeEditMotoristaModal() {
        this.$refs["edit-motorista-modal"].hide();
      },
      closeEditVeiculoModal() {
        this.$refs["edit-veiculo-modal"].hide();
      },
      setFilterMotoristaIsActive() {
        this.tableHeader = "Total de motoristas";
        this.getMotoristaData();
      },
      setFilterVeiculoIsActive() {
        this.tableHeader = "Total de veículos";
        this.getVeiculoData();
      },
      showAlertMotoristaCreate() {
        this.showSuccessAlert = true;
        this.alertMessage = "Motorista foi criado com sucesso!";
      },
      showAlertVeiculoCreate() {
        this.showSuccessAlert = true;
        this.alertMessage = "Veículo foi criado com sucesso!";
      },
      showAlertMotoristaUpdate() {
        this.showSuccessAlert = true;
        this.alertMessage = "Motorista foi atualizado com sucesso!";
      },
      showAlertVeiculoUpdate() {
        this.showSuccessAlert = true;
        this.alertMessage = "Veículo foi atualizado com sucesso!";
      },
      showDeleteMotoristaModal(id) {
        this.$refs["delete-motorista-modal"].show();
        this.motoristaId = id;
      },
      showDeleteVeiculoModal(id) {
        this.$refs["delete-veiculo-modal"].show();
        this.veiculoId = id;
      },
      closeDeleteMotoristaModal() {
        this.$refs["delete-motorista-modal"].hide();
      },
      closeDeleteVeiculoModal() {
        this.$refs["delete-veiculo-modal"].hide();
      },
      showDeleteMotoristaSuccessModal() {
        this.showSuccessAlert = true;
        this.alertMessage = "Motorista foi deletado com sucesso!";
      },
      showDeleteVeiculoSuccessModal() {
        this.showSuccessAlert = true;
        this.alertMessage = "Veículo foi deletado com sucesso!";
      },
    },
  };
  </script>
  
  <style>
  .action-item:hover {
    cursor: pointer;
  }
  </style>