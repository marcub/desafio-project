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
            <b-col cols="6">
              <b-row style="justify-content: end;">
                <b-button flex
                  variant="primary"
                  id="show-btn"
                  style="width: auto"
                  @click="showCreateMotoristaModal"
                >
                  <b-icon-plus class="text-white"></b-icon-plus>
                  <span class="h6 text-white">Novo motorista</span>
                </b-button>
                <b-button flex
                  class="ms-2"
                  variant="primary"
                  id="show-btn"
                  style="width: auto"
                  @click="showCreateVeiculoModal"
                >
                  <b-icon-plus class="text-white"></b-icon-plus>
                  <span class="h6 text-white">Novo veículo</span>
                </b-button>
              </b-row>
            </b-col>
          </b-row>
          <b-row v-show="showFilterMotorista">
            <b-row>
              <b-col class="mb-3 mt-3">
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Procure pelo nome"
                    v-model="searchNome"
                  />
                  <div class="input-group-append">
                    <button
                      class="btn btn-outline-secondary"
                      type="button"
                      @click="page = 1; getMotoristaData();"
                    >
                      <b-icon icon="search"></b-icon>
                    </button>
                  </div>
                </div>
              </b-col>
            </b-row>
            <b-row class="mt-2">
              <b-col cols="2">
                <b-form-group label="Categoria CNH">
                  <b-form-select
                    id="categoria"
                    class="form-select"
                    v-model="searchCategoria"
                    :options="optionsCategoria"
                    @change="getMotoristaData"
                  ></b-form-select>
                </b-form-group>
              </b-col>
              <b-col cols="10">
                <b-form-group label="Data de Nascimento">
                  <b-row
                  class="ms-0"
                  >
                    <label class="ms-0" style="width: fit-content; align-self: center;">De: </label>
                    <b-form-input
                      class="w-25"
                      type="date"
                      v-model="searchStartDate"
                      @input="getMotoristaData"
                    ></b-form-input>
                    <label style="width: fit-content; align-self: center;">Até: </label>
                    <b-form-input
                      class="w-25"
                      type="date"
                      v-model="searchEndDate"
                      @input="getMotoristaData"
                    ></b-form-input>
                  </b-row>
                </b-form-group>
              </b-col>
            </b-row>
          </b-row>
          <b-row v-show="showFilterVeiculo">
            <b-row>
              <b-col class="mb-3 mt-3">
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Procure pelo nome do proprietário"
                    v-model="searchNome"
                  />
                  <div class="input-group-append">
                    <button
                      class="btn btn-outline-secondary"
                      type="button"
                      @click="page = 1; getVeiculoData()"
                    >
                      <b-icon icon="search"></b-icon>
                    </button>
                  </div>
                </div>
              </b-col>
            </b-row>
            <b-row class="mt-2">
              <b-col cols="2">
                <b-form-group label="Tipo">
                  <b-form-select
                    id="tipo"
                    class="form-select"
                    v-model="searchTipo"
                    :options="optionsTipo"
                    @change="getVeiculoData"
                  ></b-form-select>
                </b-form-group>
              </b-col>
              <b-col cols="10">
                <b-form-group label="Data de criação">
                  <b-row
                  class="ms-0"
                  >
                    <label style="width: fit-content; align-self: center;">De: </label>
                    <b-form-input
                      class="w-25"
                      type="date"
                      v-model="searchStartDate"
                      @input="getVeiculoData"
                    ></b-form-input>
                    <label style="width: fit-content; align-self: center;">Até: </label>
                    <b-form-input
                      class="w-25"
                      type="date"
                      v-model="searchEndDate"
                      @input="getVeiculoData"
                    ></b-form-input>
                  </b-row>
                </b-form-group>
              </b-col>
            </b-row>
          </b-row>
          <b-row class="mt-3">
            <b-table
              striped
              hover
              :items="items"
              :fields="fields"
              class="text-center"
            >
              <template #cell(actionsMotorista)="data">
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
              <template #cell(actionsVeiculo)="data">
                <b-row>
                  <b-col cols="7">
                    <b-icon-pencil-square
                      class="action-item"
                      variant="primary"
                      @click="getRowVeiculoData(data.item.id)"
                    ></b-icon-pencil-square>
                  </b-col>
                  <b-col cols="1">
                    <b-icon-trash-fill
                      class="action-item"
                      variant="danger"
                      @click="showDeleteVeiculoModal(data.item.id)"
                    ></b-icon-trash-fill>
                  </b-col>
                </b-row>
              </template>
            </b-table>
            <b-pagination
              v-model="page"
              :total-rows="count"
              :per-page="pageSize"
              @change = "handlePageChange"
            ></b-pagination>
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
  import EditVeiculoForm from "./EditVeiculoForm.vue";
  import DeleteMotoristaModal from "./DeleteMotoristaModal.vue";
  import DeleteVeiculoModal from "./DeleteVeiculoModal.vue";
  
  export default {
    components: {
      Overview,
      CreateMotoristaForm,
      CreateVeiculoForm,
      EditMotoristaForm,
      EditVeiculoForm,
      DeleteMotoristaModal,
      DeleteVeiculoModal,
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
          {
            key: "cnh.numero",
            label: "Número da CNH",
            sortable: false,
          },
          {
            key: "cnh.categoria",
            label: "Categorria",
            sortable: false,
          },
          {
            key: "cnh.validade",
            label: "Validade",
            sortable: false,
          },
          {
            key: "actionsMotorista",
            label: "Ações",
            sortable: false,
          },
        ],
        showFilterMotorista: true,
        showFilterVeiculo:false,
        items: [],
        numeroDeMotoristas: 0,
        numeroDeVeiculos: 0,
        motoristaId: 0,
        veiculoId: 0,
        companySearchTerm: "",
        tableHeader: "",
        showSuccessAlert: false,
        alertMessage: "",
        page: 1,
        pageSize: 10,
        count: null,
        searchNome: null,
        searchCategoria: null,
        searchStartDate: null,
        searchEndDate: null,
        searchTipo: null,
        optionsCategoria: [
          { value: null, text: 'Todos' },
          'A', 
          'B', 
          'C', 
          'D', 
          'E'
        ],
        optionsTipo: [
          { value: null, text: 'Todos' },
          'Caminhões Leves', 
          'Caminhões Pesados', 
          'Veículos de Carga Especializada', 
          'Veículos de Entrega Expressa', 
          'Veículos de Transporte Intermodal', 
          'Veículos Autônomos'
        ],
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
      handlePageChange(value) {
        this.page = value;
        if (this.showFilterMotorista) {
          this.getMotoristaData();
        } else {
          this.getVeiculoData();
        }
      },
      toggleFilters() {
        this.showFilterVeiculo = !this.showFilterVeiculo;
        this.showFilterMotorista = !this.showFilterMotorista;
      },
      getMotoristaData() {
        axios
          .get("http://localhost:8000/motoristas/page", 
          {
            params: {
              nome: this.searchNome,
              categoria: this.searchCategoria,
              startDate: this.searchStartDate,
              endDate: this.searchEndDate,
              page: this.page,
              pageSize: this.pageSize,
              
            }
          })
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
                {
                  key: "cnh.numero",
                  label: "Número da CNH",
                  sortable: false,
                },
                {
                  key: "cnh.categoria",
                  label: "Categorria",
                  sortable: false,
                },
                {
                  key: "cnh.validade",
                  label: "Validade",
                  sortable: false,
                },
                {
                  key: "actionsMotorista",
                  label: "Ações",
                  sortable: false,
                },
            ];
            this.tableHeader = "Total de motoristas";
            response.data.motoristas.forEach((item, index) => {
              var dateNascimento = new Date(item.dataNascimento.substring(0, 10));
              item.dataNascimento = dateNascimento.toLocaleDateString("pt-BR");
              var dateValidade = new Date(item.cnh.validade.substring(0, 10));
              item.cnh.validade = dateValidade.toLocaleDateString("pt-BR");
            });
            this.items = response.data.motoristas;
            this.count = response.data.totalItems;
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

          axios
          .get("http://localhost:8000/motoristas/")
          .then((response) => {
            this.numeroDeMotoristas = response.data.length;
          })
          .catch((error) => {
            console.log(error);
          });
      },
      getVeiculoData() {
        axios
          .get("http://localhost:8000/veiculos/page", 
          {
            params: {
              nome: this.searchNome,
              tipo: this.searchTipo,
              startDate: this.searchStartDate,
              endDate: this.searchEndDate,
              page: this.page,
              pageSize: this.pageSize,
              
            }
          })
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
                {
                  key: "actionsVeiculo",
                  label: "Ações",
                  sortable: false,
                },
            ];
            this.tableHeader = "Total de veículos";
            response.data.veiculos.forEach((item, index) => {
              var dateCriacao = new Date(item.createdAt);
              item.createdAt = dateCriacao.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' });
            });
            this.items = response.data.veiculos;
            this.count = response.data.totalItems;
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

          axios
          .get("http://localhost:8000/motoristas/")
          .then((response) => {
            this.numeroDeMotoristas = response.data.length;
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
        this.page = 1;
        this.searchNome = null;
        this.searchCategoria = null;
        this.searchTipo = null;
        this.searchStartDate = null;
        this.searchEndDate = null;
        this.toggleFilters();
        this.getMotoristaData();
      },
      setFilterVeiculoIsActive() {
        this.tableHeader = "Total de veículos";
        this.page = 1;
        this.searchNome = null;
        this.searchCategoria = null;
        this.searchTipo = null;
        this.searchStartDate = null;
        this.searchEndDate = null;
        this.toggleFilters();
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