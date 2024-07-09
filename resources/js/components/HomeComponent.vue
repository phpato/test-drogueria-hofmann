<style>
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 5px;
}
</style>
<template>
    <div class="container">
        <h1>Lista de Usuarios</h1>
        <div class="row">
            <div class="col-12">
                <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td>{{ user.id }}</td>
                        <td>{{ user.code }}</td>
                        <td>{{ amountFormat(user.amount) }}</td>
                        <td>{{ formatDate(user.date) }}</td>
                        <td>
                            <button class="btn btn-warning text-white" tooltip="Editar" @click="editUser(user)">
                            Editar
                            </button>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
        <!-- Modal para editar usuario -->
        <div class="modal" v-if="modalOpen">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Usuario</h5>
                    <button type="button" class="close" @click="modalOpen = false">
                    <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario con los campos para editar la información del usuario -->
                    <form>
                    <div class="form-group">
                        <label for="code">Código:</label>
                        <select class="form-control" v-model="selectedUser.code">
                            <option>Seleccione una opcion</option>
                            <option v-for="code in codes" :key="code.code">
                                {{ code.code }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Monto:</label>
                        <input type="text" class="form-control" id="amount" v-model="selectedUser.amount">
                    </div>
                    <div class="form-group">
                        <label for="date">Fecha:</label>
                        <input type="text" class="form-control" id="date" v-model="selectedUser.date">
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="modalOpen = false">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="sendData">Guardar cambios</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
        users: [],
        modalOpen: false,
        selectedUser: {},
        codes: []
    }
  },
  mounted() {
    this.fetchUsers();
    this.getCodeUsers();
  },
  methods: {
    //endpoint para listar usuarios
    async fetchUsers() {
      try {
        const response = await axios.get('http://localhost:8000/get_list_clients');
        this.users = response.data;
      } catch (error) {
        console.error('Error llamada endpoint get_list_clients',error);
      }
    },
    async getCodeUsers() {
      try {
        const response = await axios.get('http://localhost:8000/get_code_users');
        this.codes = response.data;
      } catch (error) {
        console.error('Error llamada endpoint get_code_users',error);
      }
    },
    async sendData() {
      try {
        const data = {
            'id': this.selectedUser.id,
            'code': this.selectedUser.code,
            'amount': this.selectedUser.amount,
            'date': this.selectedUser.date,
            'github': 'phpato'
        };
        console.log('la info a enviar es: ', data);
        const response = await axios.post('http://localhost:8000/send_data', data);
        Swal.fire({
            title: "Usuario enviado",
            text: "Exito",
            icon: "success"
        });
        this.modalOpen = false;
        this.selectedUser = {};
      } catch (error) {
        Swal.fire({
            title: "Error",
            text: "Ocurrio un error inesperado",
            icon: "error"
        });
      }
    },
    //formato moneda local
    amountFormat(amount) {
      return amount.toLocaleString('es-CL', { style: 'currency', currency: 'CLP' });
    },
    //formato fecha loca
    formatDate(date){
        const formatedDate = new Date(date);
        return formatedDate.toLocaleString();
    },
    //funcion para rellenar la modal con los datos de la fila clickeada
    editUser(user) {
        this.modalOpen = true;
        this.selectedUser = user;
    }
  }
}
</script>
