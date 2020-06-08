<template>
    <div>
        <form-component :showModal="showModal">
            <template v-slot:title>Administración de Usuarios</template>
            <template v-slot:modal-header>
                <h5 class="modal-title" id="exampleModalLabel">
                    {{ modalTitle }}
                </h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                    @click="closeModal()"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </template>
            <template v-slot:modal-body>
                <form class="form-horizontal">
                  <div class="row">
                     <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                           <label class="form-control-label" for="name"
                              >Nombre de usuario</label>
                           <input
                              type="text"
                              id="name"
                              pattern="[A-Za-z]"
                              class="form-control"
                              required
                              v-model="user.name"
                              :class="[verifyName ? 'is-valid' : '']"
                              v-has-error="errors.name"
                           />
                           <template v-if="verifyName">
                              <div class="valid-feedback">
                                 Campo ingresado correctamente
                              </div>
                           </template>
                        </div>
                     </div>
                     <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                           <label class="form-control-label" for="email"
                              >Correo electronico</label>
                           <input
                              type="email"
                              id="email"
                              pattern="[A-Za-z]"
                              class="form-control"
                              required
                              v-model="user.email"
                              :class="[verifyEmail ? 'is-valid' : '']"
                              v-has-error="errors.email"
                           />
                           <template v-if="verifyEmail">
                              <div class="valid-feedback">
                                 Campo ingresado correctamente
                              </div>
                           </template>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                           <label class="form-control-label" for="role_id"
                              >Contraseña</label>
                           <input
                              type="password"
                              id="password"
                              class="form-control"
                              required
                              v-model="user.password"
                              :class="[verifyPassword ? 'is-valid' : '']"
                              v-has-error="errors.password"
                           />
                           <template v-if="verifyPassword">
                              <div class="valid-feedback">
                                 Campo ingresado correctamente
                              </div>
                           </template>
                        </div>
                     </div>
                     <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                           <label class="form-control-label" for="role">Rol</label>
                           <select id="role" class="form-control" v-model="user.role_id" :class="[verifyRole ? 'is-valid' : '']" v-has-error="errors.name">
                              <option value="0" disabled>Seleccionar...</option>
                              <option :value="role.id" v-for="role in roles" :key="role.id">{{ role.name }}</option>
                           </select>
                           <template v-if="verifyRole">
                              <div class="valid-feedback">
                                 Campo ingresado correctamente
                              </div>
                           </template>
                        </div>
                     </div>
                  </div>
                </form>
            </template>
            <template v-slot:modal-footer>
               <template v-if="modalBtnAction == 1">
                  <button type="button" class="btn btn-outline-danger" @click="closeModal()">Cancelar</button>
                  <button type="button" class="btn btn-primary" @click="saveUser()" :disabled="btnDisable">{{btnText}}</button>
               </template>
               <template v-if="modalBtnAction == 2">
                  <button type="button" class="btn btn-outline-danger" @click="closeModal()">Cancelar</button>
                  <button type="button" class="btn btn-primary" @click="modifyUser()">Actualizar</button>
               </template>
            </template>
        </form-component>
        <table-component>
            <template v-slot:card-header>
               <button type="button" class="btn btn-primary" @click="openModal('registrar')">
                  <i class="icon-plus"></i>&nbsp;Nuevo
               </button>
            </template>
            <template v-slot:card-search>
               <select class="form-control col-md-3" v-model="criterio">
                  <option value="name">Nombre</option>
               </select>
               <input
                  type="text"
                  class="form-control"
                  placeholder="Texto a buscar"
                  v-model="buscar"
                  @keyup.enter="getAllUsers(1, buscar, criterio)"
               />
               <button type="submit" class="btn btn-primary" @click="getAllUsers(1, buscar, criterio)">
                  <i class="fa fa-search"></i> Buscar
               </button>
            </template>
            <template v-slot:table-header>
               <th>Usuario</th>
               <th>Correo electronico</th>
               <th>Rol</th>
               <th>Estado</th>
               <th>Opciones</th>
            </template>
            <template v-slot:table-body>
                <tr v-for="user in users" :key="user.id">
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.role }}</td>
                    <td>
                        <span class="badge badge-success" v-if="user.status == '1'">activo</span>
                        <span class="badge badge-warning" v-if="user.status == '0'">inactivo</span>
                    </td>
                    <td>
                        <button @click="openModal('actualizar', user)" class="btn btn-sm btn-warning">
                           <i class="mdi mdi-pencil"></i>
                        </button>
                        <button @click="deleteUser(user.id,user.name)" class="btn btn-sm btn-danger">
                           <i class="mdi mdi-delete"></i>
                        </button>
                    </td>
                </tr>
            </template>
        </table-component>
         <br />
         <nav>
            <ul class="pagination">
               <li class="page-item" v-if="pagination.current_page > 1">
                  <a class="page-link" href="#" @click.prevent=" changePage(pagination.current_page - 1,buscar,criterio)">Ant</a>
               </li>
               <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                  <a class="page-link" href="#" @click.prevent="changePage(page, buscar, criterio)">{{ page }}</a>
               </li>
               <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                  <a class="page-link" href="#" @click.prevent=" changePage(pagination.current_page + 1,buscar,criterio)">Sig</a>
               </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
   mounted() {
      this.getAllUsers(1, "", "name");
   },
   data() {
      return {
         users: [],
         roles:[],
         errors:[],
         user: {
            role_id:0,
            name: "",
            password:"",
            email:"",
         },
         showModal: 0,
         modalTitle: 0,
         modalBtnAction: 0,
         buscar: "",
         criterio: "name",
         pagination: {
               total: 0,
               current_page: 0,
               per_page: 0,
               last_page: 0,
               from: 0,
               to: 0
         },
         offset: 3,
         btnDisable:false,
         btnText:"Registrar"
      };
   },
   computed: {
      verifyName() {
         if(this.user.name != ""){
            delete this.errors['name'];
            return true;           
         }else{
            return false;
         }
      },
      verifyEmail() {
         if(this.user.email != ""){
            delete this.errors['email'];
            return true;
         }else{
            return false
         }
      },
      verifyPassword() {
         if(this.user.password != ""){
            delete this.errors['password'];
            return true;
         }else{
            return false
         }
      },
      verifyRole() {
         if(this.user.role_id != ""){
            delete this.errors['role_id'];
            return true;
         }else{
            return false
         }
      },
      isActived() {
         return this.pagination.current_page;
      },
      pagesNumber() {
         if (!this.pagination.to) { return []; }
         let from = this.pagination.current_page - this.offset;
         if (from < 1) {
               from = 1;
         }

         let to = from + this.offset * 2;
         if (to >= this.pagination.last_page) {
               to = this.pagination.last_page;
         }
         let pagesArray = [];
         while (from <= to) {
               pagesArray.push(from);
               from++;
         }
         return pagesArray;
      },
   },
   methods: {
      async getAllUsers(page, buscar, criterio) {
         let url = `users?page=${page}&buscar=${buscar}&criterio=${criterio}`;
         const response = await axios.get(url);
         this.users = response.data.users.data;
         this.pagination = response.data.pagination;
      },
      changePage(page, buscar, criterio) {
         //actualiza la pagina actual
         this.pagination.current_page = page;
         //envia la peticion para visualizar la data de la pagina
         this.getAllUsers(page, buscar, criterio);
      },
      async selectRoles(){
         const response = await axios.get('roles/select');
         this.roles = response.data;
      },
      saveUser() {
         this.btnText="Registrando...";
         this.btnDisable=true;
         axios.post("users/save", this.user)
            .then((response) => {
               this.errors=[];
               this.btnDisable=false;
               this.btnText="Registrar";
               this.getAllUsers(1, "", "name");
               this.closeModal();
            }).catch((error => {
               if(error.response.status == 422) {
                     this.errors = error.response.data.errors;
                     this.btnDisable=false;
                     this.btnText="Registrar";
               }
            }))
      },
      async modifyUser() {
         const response = await axios.put("users/modify", this.user);
         this.getAllUsers(1, "", "name");
         this.closeModal();
      },
      async deleteUser(id,name) {
         Swal.fire({
         title: `Esta seguro de eliminar al usuario ${name}?`,
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Aceptar!",
         cancelButtonText: "Cancelar!"
         }).then(result => {
            if (result.value) {
               axios.axios.delete(`users/delete?id=${id}`)
                  .then(response => {
                     this.getAllUsers(1,'','name');
                     Swal.fire(
                        "Eliminado!",
                        "El usuario ha sido eliminado con exito",
                        "success"
                     );
                  });
            }
         });
      },
      openModal(action, data = []) {
         switch (action) {
            case "registrar": {
               this.showModal = 1;
               this.modalTitle = "Nueva Usuario";
               this.modalBtnAction = 1;
               break;
            }
            case "actualizar": {
               this.showModal = 1;
               this.modalTitle = "Actualizar Usuario";
               this.modalBtnAction = 2;
               this.user.name = data["name"];
               this.user.email = data["email"];
               this.user.password = data["password"];
               this.user.role_id = data["role_id"];
               this.user.id = data["id"];
               break;
            }
         }
         this.selectRoles();
      },
      closeModal() {
         this.showModal = 0;
         this.modalTitle = "";
         this.user.name = "", 
         this.user.email = "";
         this.user.password = "";
         this.user.role_id = 0;
         delete this.user['id'];
      }
   }
};
</script>

<style>
.modal-content {
    width: 100% !important;
    position: absolute !important;
    margin-top: 5em;
}
.mostrar {
    display: list-item !important;
    opacity: 1 !important;
    position: absolute !important;
    background-color: #3c29297a !important;
}
.file-message {
    font-size: 0.8rem;
}
.icono {
    font-size: 1.2rem;
}
</style>
