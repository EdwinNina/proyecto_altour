<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Categorias</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Categorias</li>
            </ol>
        </div>
        <div class="modal fade" :class="{'mostrar':mostrarModal}" id="exampleModal" style="display:none" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ modalTitle }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal()">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="form-control-label" for="name">Nombre</label>
                            <input type="text" id="name" pattern="[A-Za-z]" class="form-control" required 
                                v-model="category.name" :class="[verifyName ? 'is-valid': 'is-invalid']">
                                <template v-if="!verifyName">
                                    <div class="invalid-feedback">
                                        Ingrese el campo del nombre
                                    </div>                                    
                                </template>
                                <template v-if="verifyName">
                                    <div class="valid-feedback">
                                        Campo ingresado correctamente
                                    </div>                                    
                                </template>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" @change="getImage($event)">
                            <label class="custom-file-label" for="image" :class="[verifyImage ? 'is-valid': 'is-invalid']">Seleccionar imagen</label>
                                <template v-if="!verifyImage">
                                    <div class="invalid-feedback">
                                        Ingrese el campo del nombre
                                    </div>                                    
                                </template>
                                <template v-if="verifyImage">
                                    <div class="valid-feedback">
                                        Campo ingresado correctamente
                                    </div>                                    
                                </template>

                        </div>
                        <span v-if="nameFile!=''" class="file-message text-primary">La imagen seleccionada es: {{nameFile}}</span>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <template v-if="modalBtnAction == 1">
                        <button type="button" class="btn btn-default" @click="closeModal()">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="saveCategory()">Registrar</button>
                    </template>
                    <template v-if="modalBtnAction == 2">
                        <button type="button" class="btn btn-default" @click="closeModal()">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="modifyCategory()">Actualizar</button>
                    </template>
                </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" @click="openModal('registrar')">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                                <option value="name">Nombre</option>
                            </select>
                            <input type="text" 
                                class="form-control" 
                                placeholder="Texto a buscar" 
                                v-model="buscar"
                                @keyup.enter="getAllCategories(1, buscar, criterio)"
                            >
                            <button type="submit" class="btn btn-primary" @click="getAllCategories(1, buscar, criterio)"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-striped align-items-center">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Imagen</th>
                            <th>Estado</th>
                            <th>Opciones</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="category in categories" :key="category.id">
                            <td>{{ category.id }}</td>
                            <td>{{ category.name }}</td>
                            <td><img :src="`images/categories/${category.image}`" width="40" height="40" alt=""></td>
                            <td><span class="badge badge-success" v-if="category.status == '1'">activo</span>
                                <span class="badge badge-warning" v-if="category.status == '0'">inactivo</span></td>
                            <td>
                                <button @click="openModal('actualizar', category)" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i></button>
                                <template v-if="category.status">
                                    <button @click="desactiveCategory(category.id)" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash "></i></button>
                                </template>
                                <template v-else>
                                    <button @click="activeCategory(category.id)" class="btn btn-sm btn-info">
                                        <i class="fas fa-check "></i></button>
                                </template>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page - 1, buscar, criterio)">Ant</a>
                        </li>
                        <li class="page-item"
                            v-for="page in pagesNumber" :key="page"
                            :class="[page == isActived ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="changePage(page, buscar, criterio)">{{ page }}</a>
                        </li>
                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page + 1, buscar, criterio)">Sig</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted(){
            this.getAllCategories(1,'','name');
        },
       data() {
           return {
                categories: [],
                categoryId: 0,
                category:{
                    name: '',
                    image: null
                },
                nameFile:'',
                mostrarModal:0,
                modalTitle:0,
                modalBtnAction:0,
                buscar:'',
                criterio:'name',
                pagination: {
                    'total'        : 0,
                    'current_page' : 0,
                    'per_page'     : 0,
                    'last_page'    : 0,
                    'from'         : 0,
                    'to'           : 0
                },
                offset: 3,

           }
       },
       computed: {
            verifyName() {
                return (this.category.name != '') ? true : false;
            },
            verifyImage(){
                return (this.category.image != null) ? true : false;
            },
            isActived() {
                return this.pagination.current_page; 
            },
            pagesNumber(){
                if(!this.pagination.to){
                    return [];
                }
                let from = this.pagination.current_page - this.offset;
                if(from < 1){
                    from = 1;
                }
                
                let to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                let pagesArray = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
       },
       
       methods: {
           async getAllCategories(page,buscar,criterio) {
               let url = `categories?page=${page}&buscar=${buscar}&criterio=${criterio}`;
               const response = await axios.get(url);
               this.categories = response.data.categories.data;
               this.pagination = response.data.pagination;
           },
            changePage(page, buscar, criterio){
                //actualiza la pagina actual
                this.pagination.current_page = page;
                //envia la peticion para visualizar la data de la pagina
                this.getAllCategories(page, buscar, criterio)
            },

           getImage(e){
               this.nameFile = e.target.files[0].name;
               this.category.image = e.target.files[0];
           },
            async saveCategory(){
                const data = new FormData();
                data.append('name',this.category.name);
                data.append('image',this.category.image);
                const response = await axios.post('categories/save', data);
                console.log(response);
                this.getAllCategories(1,'','name');
                this.closeModal();
           },
           async modifyCategory(){
               if(this.nameFile != ''){
                    const data = new FormData();
                    data.append('name', 'hola');
                    data.append('image','imagen');
                    const response = await axios.put('categories/modify',data);
                   console.log(response);
                   this.closeModal();
               }else{
                   const response = await axios.put('categories/modify',this.category);
                   console.log(response);
                   this.getAllCategories(1,'','name');
                   this.closeModal();
               }
           },
           async desactiveCategory(id){
               const response = await axios.put('categories/desactive',{ 'id':id });
               this.getAllCategories(1,'','name');
           },
           async activeCategory(id){
               const response = await axios.put('categories/active',{ 'id':id });
               this.getAllCategories(1,'','name');
           },
           openModal(action,data = []){
               switch(action){
                   case 'registrar':{
                        this.mostrarModal = 1;
                        this.modalTitle = "Nueva Categoria";
                        this.modalBtnAction = 1;
                   break;
                   }
                   case 'actualizar':{
                       this.mostrarModal = 1;
                       this.modalTitle = "Actualizar Categoria";
                       this.modalBtnAction = 2;
                       this.category.name = data['name'];
                       this.category.image = data['image'];
                       this.category.id = data['id'];
                   break;
                   }
               }
           },
           closeModal(){
                this.mostrarModal = 0;
                this.modalTitle = '';
                this.category.name = '',
                this.category.image = null
                this.nameFile='';
           }
       },
    }
</script>

<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
        margin-top: 5em;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .file-message{
        font-size: .8rem;
    }
    .icono{
        font-size: 1.2rem;
    }
</style>