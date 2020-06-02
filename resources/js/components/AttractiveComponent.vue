<template>
    <div>
        <form-component :showModal="showModal">
            <template v-slot:title>Administracion de Atractivos</template>
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
                                <select class="custom-select" id="categories" 
                                        v-model="attractive.category_id" v-has-error="errors.category_id"
                                        :class="[verifyCategory ? 'is-valid': '']">
                                    <option value="" disabled>Seleccionar...</option>
                                    <option v-for="category in categories"
                                        :key="category.id" 
                                        :value="category.id">{{ category.name }}</option>
                                </select>
                                <template v-if="verifyCategory">
                                    <div class="valid-feedback">
                                        Campo ingresado correctamente
                                    </div>                                    
                                </template>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="form-control-label" for="name">Nombre</label>
                                <input type="text" id="name" pattern="[A-Za-z]" class="form-control" required 
                                    v-model="attractive.name" v-has-error="errors.name" :class="[verifyName ? 'is-valid': '']">
                                <template v-if="verifyName">
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
                                <label class="form-control-label" for="address">Direccion</label>
                                <input type="text" id="address" class="form-control" required 
                                    v-model="attractive.address" v-has-error="errors.address" :class="[verifyAddress ? 'is-valid': '']">
                                <template v-if="verifyAddress">
                                    <div class="valid-feedback">
                                        Campo ingresado correctamente
                                    </div>                                    
                                </template>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="form-control-label" for="description">Descripcion</label>
                                <input type="text" id="description" class="form-control" required 
                                    v-model="attractive.description" v-has-error="errors.description" :class="[verifyDescription ? 'is-valid': '']">
                                <template v-if="verifyDescription">
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
                                <label class="form-control-label" for="latitude">Latitud</label>
                                <input type="text" id="latitude" class="form-control" required 
                                    v-model="attractive.latitude" v-has-error="errors.latitude" :class="[verifyLatitude ? 'is-valid': '']">
                                <template v-if="verifyLatitude">
                                    <div class="valid-feedback">
                                        Campo ingresado correctamente
                                    </div>                                    
                                </template>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="form-control-label" for="longitude">Longitud</label>
                                <input type="text" id="longitude" class="form-control" required 
                                    v-model="attractive.longitude" v-has-error="errors.longitude" :class="[verifyLongitude ? 'is-valid': '']">
                                <template v-if="verifyLongitude">
                                    <div class="valid-feedback">
                                        Campo ingresado correctamente
                                    </div>                                    
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" @change="getImage($event)" v-has-error="errors.image">
                        <template v-if="verifyImage">
                            <div class="valid-feedback">
                                Campo ingresado correctamente
                            </div>                                    
                        </template>
                        <label class="custom-file-label" for="image" :class="[verifyImage ? 'is-valid': '']">Seleccionar imagen</label>
                    </div>
                    <span v-if="nameFile!=''" class="file-message text-primary">La imagen seleccionada es: {{nameFile}}</span>
                </form>
            </template>
            <template v-slot:modal-footer>
                <template v-if="modalBtnAction == 1">
                    <button type="button" class="btn btn-outline-danger" @click="closeModal()">Cancelar</button>
                    <button type="button" class="btn btn-primary" @click="saveAttractive()" :disabled="btnDisable">{{btnText}}</button>
                </template>
                <template v-if="modalBtnAction == 2">
                    <button type="button" class="btn btn-outline-danger" @click="closeModal()">Cancelar</button>
                    <button type="button" class="btn btn-primary" @click="modifyAttractive()">Actualizar</button>
                </template>
            </template>            
        </form-component>
        <template v-if="showContent == 1">
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
                                <button @click="desactiveAttractive(attractive.id,attractive.name)" class=" btn btn-sm btn-danger">
                                    <i class="fas fa-trash "></i></button>
                            </template>
                            <template v-else>
                                <button @click="activeAttractive(attractive.id,attractive.name)" class=" btn btn-sm btn-success">
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
        </template>
        <template v-if="showContent == 2">
            <div class="card">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <img class="card-img-top" :src="`images/attractives/${attractiveDetails.image}`" alt="Card image cap">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="card-body">
                            <p class="card-text"><small class="text-primary">Lugar turistico: {{attractiveDetails.categoryName}}</small></p>
                            <h5 class="card-title"><span class="font-weight-bold">Atractivo:</span> {{attractiveDetails.name}}</h5>
                            <p class="card-text"><span class="font-weight-bold">Descripcion:</span> {{ attractiveDetails.description}}</p>
                            <p class="card-text"><span class="font-weight-bold">Dirección:</span> {{ attractiveDetails.address}}</p>
                            <p class="card-text"><span class="font-weight-bold">Latitude:</span> {{ attractiveDetails.latitude}}</p>
                            <p class="card-text"><span class="font-weight-bold">Longitude:</span> {{ attractiveDetails.longitude}}</p>
                        </div>
                        <div class="card-footer">
                            <button @click="closeDetail()" class="btn btn-outline-primary"><i class="fas fa-arrow-left"></i> Volver</button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
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
                attractiveDetails:[],
                errors:[],
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
                showContent:1,
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
                btnDisable:false,
                btnText:'Registrar'
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
            },
            verifyCategory() {
                if(this.attractive.category_id != ""){
                    delete this.errors['category_id'];
                    return true;           
                }else{
                    return false;
                }
            },
            verifyName() {
                if(this.attractive.name != ""){
                    delete this.errors['name'];
                    return true;           
                }else{
                    return false;
                }
            },
            verifyDescription() {
                if(this.attractive.description != ""){
                    delete this.errors['description'];
                    return true;           
                }else{
                    return false;
                }
            },
            verifyAddress() {
                if(this.attractive.address != ""){
                    delete this.errors['address'];
                    return true;           
                }else{
                    return false;
                }
            },
            verifyLatitude() {
                if(this.attractive.latitude != ""){
                    delete this.errors['latitude'];
                    return true;           
                }else{
                    return false;
                }
            },
            verifyLongitude() {
                if(this.attractive.longitude != ""){
                    delete this.errors['longitude'];
                    return true;           
                }else{
                    return false;
                }
            },
            verifyImage() {
                if(this.attractive.image != ""){
                    delete this.errors['image'];
                    return true;           
                }else{
                    return false;
                }
            },
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
            saveAttractive(){
                this.btnText="Registrando...";
                this.btnDisable=true;
                const data = new FormData();
                data.append('category_id',this.attractive.category_id);
                data.append('name',this.attractive.name);
                data.append('description',this.attractive.description);
                data.append('address',this.attractive.address);
                data.append('latitude',this.attractive.latitude);
                data.append('longitude',this.attractive.longitude);
                data.append('image',this.attractive.image);
                axios.post('attractives/save', data)
                    .then((response) => {
                        this.errors=[];
                        this.btnDisable=false;
                        this.btnText="Registrar";
                        this.getAllAttractives(1,'','name');
                        this.closeModal();
                    }).catch((error) => {
                        if(error.response.status == 422) {
                            this.errors = error.response.data.errors;
                            this.btnDisable=false;
                            this.btnText="Registrar";
                        }
                    })
            },
            async modifyAttractive(){
					let formdata = new FormData();
					formdata.append('id',this.attractive.id);
					formdata.append('category_id',this.attractive.category_id);
					formdata.append('name', this.attractive.name);
					formdata.append('description',this.attractive.description);
					formdata.append('address',this.attractive.address);
					formdata.append('latitude',this.attractive.latitude);
					formdata.append('longitude',this.attractive.longitude);
					formdata.append('image',this.attractive.image);
					const response = await axios.post('attractives/modify', formdata);
					console.log(response);
					this.getAllAttractives(1,'','name');
					this.closeModal();
            },
            async openDetail(id){
               let url = `attractives/detail?id=${id}`
               const response = await axios.get(url);
               this.attractiveDetails = response.data;
               this.showContent = 2; 
            },
            desactiveAttractive(id,name){
                Swal.fire({
                title: `Esta seguro de desactivar el attractivo ${name}?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar!",
                cancelButtonText: "Cancelar!"
                }).then(result => {
                    if (result.value) {
                        axios.put("attractives/desactive", { id: id })
                            .then(response => {
                                this.getAllAttractives(1,'','name');
                                Swal.fire(
                                    "Activado!",
                                    "El atractivo ha sido desactivado con exito",
                                    "success"
                                );
                            });
                    }
                });
            },
            activeAttractive(id,name){
                Swal.fire({
                title: `Esta seguro de activar el attractivo ${name}?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar!",
                cancelButtonText: "Cancelar!"
                }).then(result => {
                    if (result.value) {
                        axios.put("attractives/active", { id: id })
                            .then(response => {
                                this.getAllAttractives(1,'','name');
                                Swal.fire(
                                    "Activado!",
                                    "El atractivo ha sido activado con exito",
                                    "success"
                                );
                            });
                    }
                });
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
                this.attractive.category_id = '',
                this.attractive.name = '',
                this.attractive.description = '',
                this.attractive.address = '',
                this.attractive.latitude = '',
                this.attractive.longitude = '',
                this.attractive.image = null
                this.nameFile='';
                this.errors=[];
            },
            closeDetail(){
                this.showContent=1;
                this.getAllAttractives(1,'','name');
            }
        },
    }
</script>

<style>
    .file-message{
        font-size: .8rem;
    }
</style>