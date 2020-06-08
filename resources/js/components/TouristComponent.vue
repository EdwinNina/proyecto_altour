<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between">
            <h1 class="h3 mb-0 text-gray-800">Lista de Turistas</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Turistas</li>
            </ol>
        </div>
        <table-component>
            <template v-slot:card-search>
               <select class="form-control col-md-3" v-model="criterio">
                  <option value="name">Nombre</option>
               </select>
               <input
                  type="text"
                  class="form-control"
                  placeholder="Texto a buscar"
                  v-model="buscar"
                  @keyup.enter="getAllTourists(1, buscar, criterio)"
               />
               <button type="submit" class="btn btn-primary" @click="getAllTourists(1, buscar, criterio)">
                  <i class="fa fa-search"></i> Buscar
               </button>
            </template>
            <template v-slot:table-header>
               <th>Usuario</th>
               <th>Correo electronico</th>
               <th>Rol</th>
               <th>Estado</th>
            </template>
            <template v-slot:table-body>
                <tr v-for="tourist in tourists" :key="tourist.id">
                    <td>{{ tourist.name }}</td>
                    <td>{{ tourist.email }}</td>
                    <td>{{ tourist.role }}</td>
                    <td>
                        <span class="badge badge-success" v-if="tourist.status == '1'">activo</span>
                        <span class="badge badge-warning" v-if="tourist.status == '0'">inactivo</span>
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
      this.getAllTourists(1, "", "name");
   },
   data() {
      return {
         tourists: [],
         roles:[],
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
      };
   },
   computed: {
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
      async getAllTourists(page, buscar, criterio) {
         let url = `users/tourists?page=${page}&buscar=${buscar}&criterio=${criterio}`;
         const response = await axios.get(url);
         this.tourists = response.data.tourists.data;
         this.pagination = response.data.pagination;
      },
      changePage(page, buscar, criterio) {
         //actualiza la pagina actual
         this.pagination.current_page = page;
         //envia la peticion para visualizar la data de la pagina
         this.getAllTourists(page, buscar, criterio);
      },
   }
};
</script>
