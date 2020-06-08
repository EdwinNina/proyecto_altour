<template>
    <div>
        <form-component :showModal="showModal">
            <template v-slot:title>Administración de Roles</template>
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
                     <div class="col-sm-12">
                        <div class="form-group">
                           <label class="form-control-label" for="name"
                              >Rol</label>
                           <input
                              type="text"
                              id="name"
                              pattern="[A-Za-z]"
                              class="form-control"
                              required
                              v-model="role.name"
                              :class="[verifyRole ? 'is-valid' : '']"
                              v-has-error="errors.name"
                           />
                           <template v-if="verifyRole">
                              <div class="valid-feedback">
                                 Campo ingresado correctamente
                              </div>
                           </template>
                        </div>
                     </div>
                     <div class="col-sm-12">
                        <div class="form-group">
                           <label class="form-control-label" for="description"
                              >Description</label>
                           <input
                              type="text"
                              id="description"
                              pattern="[A-Za-z]"
                              class="form-control"
                              required
                              v-model="role.description"
                           />
                        </div>
                     </div>
                  </div>
                </form>
            </template>
            <template v-slot:modal-footer>
               <template v-if="modalBtnAction == 1">
                  <button type="button" class="btn btn-outline-danger" @click="closeModal()">Cancelar</button>
                  <button type="button" class="btn btn-primary" @click="saveRole()" :disabled="btnDisable">{{btnText}}</button>
               </template>
               <template v-if="modalBtnAction == 2">
                  <button type="button" class="btn btn-outline-danger" @click="closeModal()">Cancelar</button>
                  <button type="button" class="btn btn-primary" @click="modifyRole()">Actualizar</button>
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
                  @keyup.enter="getAllRoles(1, buscar, criterio)"
               />
               <button type="submit" class="btn btn-primary" @click="getAllRoles(1, buscar, criterio)">
                  <i class="fa fa-search"></i> Buscar
               </button>
            </template>
            <template v-slot:table-header>
               <th>Role</th>
               <th>Description</th>
               <th>Estado</th>
               <th>Opciones</th>
            </template>
            <template v-slot:table-body>
                <tr v-for="role in roles" :key="role.id">
                    <td>{{ role.name }}</td>
                    <td>
                       <span v-if="!role.description == ''">{{ role.description}}</span>
                       <span v-else>No tiene descripcion</span>
                    </td>
                    <td>
                        <span class="badge badge-success" v-if="role.status == '1'">activo</span>
                        <span class="badge badge-warning" v-if="role.status == '0'">inactivo</span>
                    </td>
                    <td>
                        <button @click="openModal('actualizar', role)" class="btn btn-sm btn-warning">
                           <i class="mdi mdi-pencil"></i>
                        </button>
                        <button @click="deleteRole(role.id,role.name)" class="btn btn-sm btn-danger">
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
      this.getAllRoles(1, "", "name");
   },
   data() {
      return {
         roles:[],
         errors:[],
         role: {
            name: "",
            description:"",
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
      verifyRole() {
         if(this.role.name != ""){
            delete this.errors['name'];
            return true;           
         }else{
            return false;
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
      async getAllRoles(page, buscar, criterio) {
         let url = `roles?page=${page}&buscar=${buscar}&criterio=${criterio}`;
         const response = await axios.get(url);
         this.roles = response.data.roles.data;
         this.pagination = response.data.pagination;
      },
      changePage(page, buscar, criterio) {
         //actualiza la pagina actual
         this.pagination.current_page = page;
         //envia la peticion para visualizar la data de la pagina
         this.getAllRoles(page, buscar, criterio);
      },
      saveRole() {
         this.btnText="Registrando...";
         this.btnDisable=true;
         axios.post("roles/save", this.role)
            .then((response) => {
               this.errors=[];
               this.btnDisable=false;
               this.btnText="Registrar";
               this.getAllRoles(1, "", "name");
               this.closeModal();
            }).catch((error => {
               if(error.response.status == 422) {
                     this.errors = error.response.data.errors;
                     this.btnDisable=false;
                     this.btnText="Registrar";
               }
            }))
      },
      async modifyRole() {
         const response = await axios.put("roles/modify", this.role);
         this.getAllRoles(1, "", "name");
         this.closeModal();
      },
      async deleteRole(id,name) {
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
               axios.delete(`roles/delete?id=${id}`)
                  .then(response => {
                     this.getAllRoles(1,'','name');
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
               this.modalTitle = "Nueva rol";
               this.modalBtnAction = 1;
               break;
            }
            case "actualizar": {
               this.showModal = 1;
               this.modalTitle = "Actualizar rol";
               this.modalBtnAction = 2;
               this.role.name = data["name"];
               this.role.description = data["description"];
               this.role.id = data["id"];
               break;
            }
         }
      },
      closeModal() {
         this.showModal = 0;
         this.modalTitle = "";
         this.role.name = "", 
         this.role.description = "";
         delete this.role['id'];
      }
   }
};
</script>
