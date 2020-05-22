<template>
    <div>
        <form-component :showModal="showModal">
            <template v-slot:title>
                Attractivos
            </template>
            <template v-slot:modal-header>
                <h5 class="modal-title" id="exampleModalLabel">{{ modalTitle }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal()">
                <span aria-hidden="true">&times;</span>
                </button>
            </template>
            <template v-slot:modal-body>
                <form class="form-horizontal" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="categories">Categoria</label>
                                <select class="custom-select" id="categories" v-model="attractive.category_id">
                                    <option value="" disabled>Seleccionar...</option>
                                    <option v-for="category in categories"
                                        :key="category.id" 
                                        :value="category.id">{{ category.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="form-control-label" for="name">Nombre</label>
                                <input type="text" id="name" pattern="[A-Za-z]" class="form-control" required v-model="attractive.name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="form-control-label" for="address">Direccion</label>
                                <input type="text" id="address" class="form-control" required v-model="attractive.address">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="form-control-label" for="description">Descripcion</label>
                                <input type="text" id="description" class="form-control" required v-model="attractive.description">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="form-control-label" for="latitude">Latitud</label>
                                <input type="text" id="latitude" class="form-control" required v-model="attractive.latitude">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="form-control-label" for="longitude">Longitud</label>
                                <input type="text" id="longitude" class="form-control" required v-model="attractive.longitude">
                            </div>
                        </div>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" @change="getImage($event)">
                        <label class="custom-file-label" for="image">Seleccionar imagen</label>
                    </div>
                    <span v-if="nameFile!=''" class="file-message text-primary">La imagen seleccionada es: {{nameFile}}</span>
                </form>
            </template>
            <template v-slot:modal-footer>
                <template v-if="modalBtnAction == 1">
                    <button type="button" class="btn btn-default" @click="closeModal()">Cancelar</button>
                    <button type="button" class="btn btn-primary" @click="saveAttractive()">Registrar</button>
                </template>
                <template v-if="modalBtnAction == 2">
                    <button type="button" class="btn btn-default" @click="closeModal()">Cancelar</button>
                    <button type="button" class="btn btn-primary" @click="modifyAttractive()">Actualizar</button>
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
                <input type="text" 
                    class="form-control" 
                    placeholder="Texto a buscar" 
                    v-model="buscar"
                    @keyup.enter="getAllAttractives(1, buscar, criterio)"
                >
                <button type="submit" class="btn btn-primary" 
                    @click="getAllAttractives(1, buscar, criterio)">
                    <i class="fa fa-search"></i> Buscar
                </button>
            </template>
            <template v-slot:table-header>
                <th>Categoria</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Dirección</th>
                <th>Latitud</th>
                <th>Longitud</th>
                <th>Imagen</th>
                <th colspan="3">Opciones</th>
            </template>
            <template v-slot:table-body>
                <tr v-for="attractive in attractives" :key="attractive.id">
                    <td>{{ attractive.category.name }}</td>
                    <td>{{ attractive.name }}</td>
                    <td>{{ attractive.description.substr(0,20)+'...' }}</td>
                    <td>{{ attractive.address }}</td>
                    <td>{{ attractive.latitude }}</td>
                    <td>{{ attractive.longitude }}</td>
                    <td><img :src="`images/attractives/${attractive.image}`" width="40" height="40" alt=""></td>
                    <td>
                        <button @click="openModal('actualizar', attractive)" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i></button>
                        <button @click="openDetail(attractive.id)" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i></button>
                        <template v-if="attractive.status">
                            <button @click="desactiveAttractive(attractive.id)" class=" btn btn-sm btn-danger">
                                <i class="fas fa-trash "></i></button>
                        </template>
                        <template v-else>
                            <button @click="activeAttractive(attractive.id)" class=" btn btn-sm btn-info">
                                <i class="fas fa-check "></i></button>
                        </template>
                    </td>
                </tr>
            </template>
        </table-component>
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
</template>

<script>
    export default {
        mounted(){
            this.getAllAttractives(1,'','name');
        },
       data() {
           return {
                attractives: [],
                categories: [],
                categoryId: 0,
                attractive:{
                    category_id: '',
                    name: '',
                    description: '',
                    address: '',
                    latitude: '',
                    longitude: '',
                    image: null
                },
                nameFile:'',
                showModal:0,
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
            async getAllAttractives(page,buscar,criterio) {
               let url = `attractives?page=${page}&buscar=${buscar}&criterio=${criterio}`;
               const response = await axios.get(url);
               this.attractives = response.data.attractives.data;
               this.pagination = response.data.pagination;
            },
            async getAllCategories(){
                const response = await axios.get('category');
                this.categories = response.data;
            },
            changePage(page, buscar, criterio){
                //actualiza la pagina actual
                this.pagination.current_page = page;
                //envia la peticion para visualizar la data de la pagina
                this.getAllAttractives(page, buscar, criterio)
            },

            getImage(e){
               this.nameFile = e.target.files[0].name;
               this.attractive.image = e.target.files[0];
            },
            async saveAttractive(){
                const data = new FormData();
                data.append('category_id',this.attractive.category_id);
                data.append('name',this.attractive.name);
                data.append('description',this.attractive.description);
                data.append('address',this.attractive.address);
                data.append('latitude',this.attractive.latitude);
                data.append('longitude',this.attractive.longitude);
                data.append('image',this.attractive.image);
                const response = await axios.post('attractives/save', data);
                this.getAllAttractives(1,'','name');
                this.closeModal();
           },
           async modifyAttractive(){
               if(this.nameFile != ''){
                    let formdata = new FormData();
                    formdata.append('category_id',this.attractive.category_id);
                    formdata.append('name', this.attractive.name);
                    formdata.append('description',this.attractive.description);
                    formdata.append('address',this.attractive.address);
                    formdata.append('latitude',this.attractive.latitude);
                    formdata.append('longitude',this.attractive.longitude);
                    formdata.append('option','nuevaImagen');
                    formdata.append('prueba','hola');
                    console.log('formdata '+formdata);
                    const response = await axios.patch('attractives/modify', formdata);
                   console.log(response);
                   this.closeModal();
               }else{
                   const response = await axios.put('attractives/modify',this.attractive);
                   console.log(response);
                   this.getAllAttractives(1,'','name');
                   this.closeModal();
               }
           },
           openDetail(id){
               let url = `attractives/detail?id=${id}`
               window.open(url);
           },
           async desactiveAttractive(id){
               const response = await axios.put('attractives/desactive',{ 'id':id });
               this.getAllAttractives(1,'','name');
           },
           async activeAttractive(id){
               const response = await axios.put('attractives/active',{ 'id':id });
               this.getAllAttractives(1,'','name');
           },
            openModal(action,data = []){
                switch(action){
                    case 'registrar':{
                        this.showModal = 1;
                        this.modalTitle = "Nuevo Atractivo";
                        this.modalBtnAction = 1;
                        this.getAllCategories();
                    break;
                    }
                    case 'actualizar':{
                       this.showModal = 1;
                       this.modalTitle = "Actualizar Atractivo";
                       this.modalBtnAction = 2;
                       this.attractive.category_id = data['category_id'];
                       this.attractive.name = data['name'];
                       this.attractive.description = data['description'];
                       this.attractive.address = data['address'];
                       this.attractive.latitude = data['latitude'];
                       this.attractive.longitude = data['longitude'];
                       this.attractive.image = data['image'];
                       this.attractive.id = data['id'];
                    break;
                    }
               }
               this.getAllCategories();
           },
           closeModal(){
                this.showModal = 0;
                this.modalTitle = '';
                this.attractive.name = '',
                this.attractive.description = '',
                this.attractive.address = '',
                this.attractive.latitude = '',
                this.attractive.longitude = '',
                this.attractive.image = null
                this.nameFile='';
           }
       },
    }
</script>

<style>
    .file-message{
        font-size: .8rem;
    }
    .icono{
        font-size: 1.2rem;
    }
    .opcionDesactivar{
        margin-left: -3em;
    }
</style>