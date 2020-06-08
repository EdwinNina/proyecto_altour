<template>
    <div>
        <form-component :showModal="showModal">
            <template v-slot:title>Administracion de Lugares Turisticos</template>
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
                                <select class="form-control" id="categories" 
                                        v-model="place.category_id" v-has-error="errors.category_id"
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
                                    v-model="place.name" v-has-error="errors.name" :class="[verifyName ? 'is-valid': '']">
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
                                    v-model="place.address" v-has-error="errors.address" :class="[verifyAddress ? 'is-valid': '']">
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
                                    v-model="place.description" v-has-error="errors.description" :class="[verifyDescription ? 'is-valid': '']">
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
                                    v-model="place.latitude" v-has-error="errors.latitude" :class="[verifyLatitude ? 'is-valid': '']">
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
                                    v-model="place.longitude" v-has-error="errors.longitude" :class="[verifyLongitude ? 'is-valid': '']">
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
                    <button type="button" class="btn btn-primary" @click="savePlace()" :disabled="btnDisable">{{btnText}}</button>
                </template>
                <template v-if="modalBtnAction == 2">
                    <button type="button" class="btn btn-outline-danger" @click="closeModal()">Cancelar</button>
                    <button type="button" class="btn btn-primary" @click="modifyPlace()">Actualizar</button>
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
                        @keyup.enter="getAllPlaces(1, buscar, criterio)"
                    >
                    <button type="submit" class="btn btn-primary" 
                        @click="getAllPlaces(1, buscar, criterio)">
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
                    <tr v-for="place in places" :key="place.id">
                        <td>{{ place.category.name }}</td>
                        <td>{{ place.name }}</td>
                        <td>{{ place.description.substr(0,20)+'...' }}</td>
                        <td>{{ place.address }}</td>
                        <td>{{ place.latitude }}</td>
                        <td>{{ place.longitude }}</td>
                        <td><img :src="`images/places/${place.image}`" width="40" height="40" alt=""></td>
                        <td>
                            <button @click="openModal('actualizar', place)" class="btn btn-sm btn-warning">
                                <i class="mdi mdi-pencil"></i></button>
                            <button @click="openDetail(place.id)" class="btn btn-sm btn-info">
                                <i class="mdi mdi-eye"></i></button>
                            <template v-if="place.status">
                                <button @click="desactivePlace(place.id,place.name)" class=" btn btn-sm btn-danger">
                                    <i class="mdi mdi-delete "></i></button>
                            </template>
                            <template v-else>
                                <button @click="activePlace(place.id,place.name)" class=" btn btn-sm btn-success">
                                    <i class="mdi mdi-check "></i></button>
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
                        <img class="card-img-top" :src="`images/places/${placeDetails.image}`" alt="Card image cap">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="card-body">
                            <p class="card-text"><small class="text-primary">Categoria: {{placeDetails.categoryName}}</small></p>
                            <h5 class="card-title"><span class="font-weight-bold">Atractivo:</span> {{placeDetails.name}}</h5>
                            <p class="card-text"><span class="font-weight-bold">Descripcion:</span> {{ placeDetails.description}}</p>
                            <p class="card-text"><span class="font-weight-bold">Dirección:</span> {{ placeDetails.address}}</p>
                            <p class="card-text"><span class="font-weight-bold">Latitude:</span> {{ placeDetails.latitude}}</p>
                            <p class="card-text"><span class="font-weight-bold">Longitude:</span> {{ placeDetails.longitude}}</p>
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
            this.getAllPlaces(1,'','name');
        },
       data() {
           return {
                places: [],
                categories: [],
                placeDetails:[],
                errors:[],
                place:{
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
                if(this.place.category_id != ""){
                    delete this.errors['category_id'];
                    return true;           
                }else{
                    return false;
                }
            },
            verifyName() {
                if(this.place.name != ""){
                    delete this.errors['name'];
                    return true;           
                }else{
                    return false;
                }
            },
            verifyDescription() {
                if(this.place.description != ""){
                    delete this.errors['description'];
                    return true;           
                }else{
                    return false;
                }
            },
            verifyAddress() {
                if(this.place.address != ""){
                    delete this.errors['address'];
                    return true;           
                }else{
                    return false;
                }
            },
            verifyLatitude() {
                if(this.place.latitude != ""){
                    delete this.errors['latitude'];
                    return true;           
                }else{
                    return false;
                }
            },
            verifyLongitude() {
                if(this.place.longitude != ""){
                    delete this.errors['longitude'];
                    return true;           
                }else{
                    return false;
                }
            },
            verifyImage() {
                if(this.place.image != ""){
                    delete this.errors['image'];
                    return true;           
                }else{
                    return false;
                }
            },
        },
        methods: {
            async getAllPlaces(page,buscar,criterio) {
               let url = `places?page=${page}&buscar=${buscar}&criterio=${criterio}`;
               const response = await axios.get(url);
               this.places = response.data.places.data;
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
                this.getAllPlaces(page, buscar, criterio)
            },
            getImage(e){
               this.nameFile = e.target.files[0].name;
               this.place.image = e.target.files[0];
            },
            savePlace(){
                this.btnText="Registrando...";
                this.btnDisable=true;
                const data = new FormData();
                data.append('category_id',this.place.category_id);
                data.append('name',this.place.name);
                data.append('description',this.place.description);
                data.append('address',this.place.address);
                data.append('latitude',this.place.latitude);
                data.append('longitude',this.place.longitude);
                data.append('image',this.place.image);
                axios.post('places/save', data)
                    .then((response) => {
                        this.errors=[];
                        this.btnDisable=false;
                        this.btnText="Registrar";
                        this.getAllPlaces(1,'','name');
                        this.closeModal();
                    }).catch((error) => {
                        if(error.response.status == 422) {
                            this.errors = error.response.data.errors;
                            this.btnDisable=false;
                            this.btnText="Registrar";
                        }
                    })
            },
            async modifyPlace(){
					let formdata = new FormData();
					formdata.append('id',this.place.id);
					formdata.append('category_id',this.place.category_id);
					formdata.append('name', this.place.name);
					formdata.append('description',this.place.description);
					formdata.append('address',this.place.address);
					formdata.append('latitude',this.place.latitude);
					formdata.append('longitude',this.place.longitude);
					formdata.append('image',this.place.image);
					const response = await axios.post('places/modify', formdata);
					this.getAllPlaces(1,'','name');
					this.closeModal();
            },
            async openDetail(id){
               let url = `places/detail?id=${id}`
               const response = await axios.get(url);
               this.placeDetails = response.data;
               this.showContent = 2; 
            },
            desactivePlace(id,name){
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
                        axios.put("places/desactive", { id: id })
                            .then(response => {
                                this.getAllPlaces(1,'','name');
                                Swal.fire(
                                    "Activado!",
                                    "El atractivo ha sido desactivado con exito",
                                    "success"
                                );
                            });
                    }
                });
            },
            activePlace(id,name){
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
                        axios.put("places/active", { id: id })
                            .then(response => {
                                this.getAllPlaces(1,'','name');
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
                        this.modalTitle = "Nuevo lugar turistico";
                        this.modalBtnAction = 1;
                        this.getAllCategories();
                    break;
                    }
                    case 'actualizar':{
                        this.showModal = 1;
                        this.modalTitle = "Actualizar lugar turistico";
                        this.modalBtnAction = 2;
                        this.place.category_id = data['category_id'];
                        this.place.name = data['name'];
                        this.place.description = data['description'];
                        this.place.address = data['address'];
                        this.place.latitude = data['latitude'];
                        this.place.longitude = data['longitude'];
                        this.place.image = data['image'];
                        this.place.id = data['id'];
                    break;
                    }
                }
                this.getAllCategories();
            },
            closeModal(){
                this.showModal = 0;
                this.modalTitle = '';
                this.place.category_id = '',
                this.place.name = '',
                this.place.description = '',
                this.place.address = '',
                this.place.latitude = '',
                this.place.longitude = '',
                this.place.image = null
                this.nameFile='';
                this.errors=[];
            },
            closeDetail(){
                this.showContent=1;
                this.getAllPlaces(1,'','name');
            }
        },
    }
</script>

<style>
    .file-message{
        font-size: .8rem;
    }
</style>