<template>
    <div>
        <form-component :showModal="showModal">
            <template v-slot:title>Administración de Actividades</template>
            <template v-slot:modal-header>
                <h5 class="modal-title" id="exampleModalLabel">{{ modalTitle }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal()">
                <span aria-hidden="true">&times;</span>
                </button>
            </template>
            <template v-slot:modal-body>
                <form class="form-horizontal">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="atractivos">Atractivo</label>
                                <v-select
                                    v-model="activity.attractive_id"
                                    :options="attractives"
                                    label="name"
                                    :reduce="attractive => attractive.id"
                                    placeholer="Seleccionar un atractivo"
                                    class="style-chooser"
                                    v-has-error="errors.attractive_id"
                                    :class="[verifyAttractive ? 'is-valid': '']"
                                >
                                <template slot="no-options">
                                    Escriba el nombre del atractivo
                                </template>
                                </v-select>
                                <template v-if="verifyAttractive">
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
                                <label class="form-control-label" for="name">Nombre</label>
                                <input type="text" id="name" pattern="[A-Za-z]" class="form-control" required 
                                    v-model="activity.name" v-has-error="errors.name" :class="[verifyName ? 'is-valid': '']">
                                <template v-if="verifyName">
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
                                    v-model="activity.description" v-has-error="errors.description" :class="[verifyDescription ? 'is-valid': '']">
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
                                <label class="form-control-label" for="instructor">Guía</label>
                                <input type="text" id="instructor" class="form-control" required 
                                    v-model="activity.instructor" v-has-error="errors.instructor" :class="[verifyInstructor ? 'is-valid': '']">
                                <template v-if="verifyInstructor">
                                    <div class="valid-feedback">
                                        Campo ingresado correctamente
                                    </div>                                    
                                </template>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="form-control-label" for="cost">Costo</label>
                                <input type="number" id="cost" class="form-control" required 
                                    v-model="activity.cost" v-has-error="errors.cost" :class="[verifyCost ? 'is-valid': '']">
                                <template v-if="verifyCost">
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
                                <label class="form-control-label" for="startDate">Fecha de Inicio</label>
                                <input type="date" id="startDate" class="form-control" required 
                                    v-model="activity.date_start" v-has-error="errors.date_start" :class="[verifyDateStart ? 'is-valid': '']">
                                <template v-if="verifyDateStart">
                                    <div class="valid-feedback">
                                        Campo ingresado correctamente
                                    </div>                                    
                                </template>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label class="form-control-label" for="endDate">Fecha de Finalización</label>
                                <input type="date" id="endDate" class="form-control" required 
                                    v-model="activity.date_end" v-has-error="errors.date_end" :class="[verifyDateEnd ? 'is-valid': '']">
                                <template v-if="verifyDateEnd">
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
                    <button type="button" class="btn btn-primary" @click="saveActivity()" :disabled="btnDisable">{{btnText}}</button>
                </template>
                <template v-if="modalBtnAction == 2">
                    <button type="button" class="btn btn-outline-danger" @click="closeModal()">Cancelar</button>
                    <button type="button" class="btn btn-primary" @click="modifyActivity()">Actualizar</button>
                </template>
            </template>            
        </form-component>
        <template  v-if="showContent == 1">
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
                        @keyup.enter="getAllActivities(1, buscar, criterio)"
                    >
                    <button type="submit" class="btn btn-primary" 
                        @click="getAllActivities(1, buscar, criterio)">
                        <i class="fa fa-search"></i> Buscar
                    </button>
                </template>
                <template v-slot:table-header>
                    <th>Attractivo</th>
                    <th>Actividad</th>
                    <th>Descripción</th>
                    <th>Instructor</th>
                    <th>Costo</th>
                    <th>Inicio</th>
                    <th>Finalización</th>
                    <th>Estado</th>
                    <th colspan="3">Opciones</th>
                </template>
                <template v-slot:table-body>
                    <tr v-for="activity in activities" :key="activity.id">
                        <td>{{ activity.attractive.name }}</td>
                        <td>{{ activity.name }}</td>
                        <td>{{ activity.description.substr(0,20)+'...' }}</td>
                        <td>{{ activity.instructor }}</td>
                        <td>{{ activity.cost + ' Bs' }}</td>
                        <td>{{ activity.date_start }}</td>
                        <td>{{ activity.date_end }}</td>
                        <td><span class="badge badge-success" v-if="activity.status == '1'">Disponible</span>
                            <span class="badge badge-warning" v-if="activity.status == '0'">Cancelado</span>
                        </td>
                        <td>
                            <button @click="openModal('actualizar', activity)" class="btn btn-sm btn-warning">
                                <i class="mdi mdi-pencil"></i></button>
                            <button @click="openDetail(activity.id)" class="btn btn-sm btn-info">
                                <i class="mdi mdi-eye"></i></button>
                            <template v-if="activity.status">
                                <button @click="desactiveActivity(activity.id,activity.name)" class=" btn btn-sm btn-danger">
                                    <i class="mdi mdi-delete"></i></button>
                            </template>
                            <template v-else>
                                <button @click="activeActivity(activity.id,activity.name)" class=" btn btn-sm btn-success">
                                    <i class="mdi mdi-check"></i></button>
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
                        <img class="card-img-top" :src="`images/attractives/${activityDetails.image}`" alt="Card image cap">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="card-body">
                            <p class="card-text"><small class="text-primary">Lugar turistico: {{activityDetails.attractiveName}}</small></p>
                            <h5 class="card-title"><span class="font-weight-bold">Actividad:</span> {{activityDetails.name}}</h5>
                            <p class="card-text"><span class="font-weight-bold">Descripcion:</span> {{ activityDetails.description}}</p>
                            <p class="card-text"><span class="font-weight-bold">Guía Asignado:</span> {{ activityDetails.instructor}}</p>
                            <p class="card-text"><span class="font-weight-bold">Costo:</span> {{ activityDetails.cost}} Bs</p>
                            <p class="card-text"><span class="font-weight-bold">Fecha inicio:</span> {{ activityDetails.date_start}}</p>
                            <p class="card-text"><span class="font-weight-bold">Fecha finalización:</span> {{ activityDetails.date_end}}</p>
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
    import vSelect from 'vue-select';
    export default {
        components: {
            'v-select': vSelect,
        },
        mounted(){
            this.getAllActivities(1,'','name');
        },
        data() {
            return {
                activities: [],
                attractives: [],
                activityDetails:[],
                errors:[],
                activity:{
                    attractive_id: 0,
                    name: '',
                    description: '',
                    instructor: '',
                    cost: '',
                    date_start: '',
                    date_end: '',
                },
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
                btnText:'Registrar',
                btnDisable:false
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
            verifyAttractive() {
                if(this.activity.attractive_id != ""){
                    delete this.errors['attractive_id'];
                    return true;           
                }else{
                    return false;
                }
            },
            verifyName() {
                if(this.activity.name != ""){
                    delete this.errors['name'];
                    return true;           
                }else{
                    return false;
                }
            },
            verifyDescription() {
                if(this.activity.description != ""){
                    delete this.errors['description'];
                    return true;           
                }else{
                    return false;
                }
            },
            verifyInstructor() {
                if(this.activity.instructor != ""){
                    delete this.errors['instructor'];
                    return true;           
                }else{
                    return false;
                }
            },
            verifyCost() {
                if(this.activity.cost != ""){
                    delete this.errors['cost'];
                    return true;           
                }else{
                    return false;
                }
            },
            verifyDateStart() {
                if(this.activity.date_start != ""){
                    delete this.errors['date_start'];
                    return true;           
                }else{
                    return false;
                }
            },
            verifyDateEnd(){
                if(this.activity.date_end != ""){
                    delete this.errors['date_end'];
                    return true;           
                }else{
                    return false;
                }
            }
        },
        methods: {
            async getAllActivities(page,buscar,criterio) {
               let url = `activities?page=${page}&buscar=${buscar}&criterio=${criterio}`;
               const response = await axios.get(url);
               this.activities = response.data.activities.data;
               this.pagination = response.data.pagination;
            },
            async selectAttractives(){
                const response = await axios.get('attractives/select');
                this.attractives = response.data;
            },
            changePage(page, buscar, criterio){
                //actualiza la pagina actual
                this.pagination.current_page = page;
                //envia la peticion para visualizar la data de la pagina
                this.getAllActivities(page, buscar, criterio)
            },
            saveActivity(){
                this.btnText="Registrando...";
                this.btnDisable=true;
                axios.post('activities/save', this.activity)
                    .then((response) => {
                        this.errors=[];
                        this.btnDisable=false;
                        this.btnText="Registrar";
                        this.getAllActivities(1,'','name');
                        this.closeModal();
                    }).catch((error => {
                        if(error.response.status == 422) {
                            this.errors = error.response.data.errors;
                            this.btnDisable=false;
                            this.btnText="Registrar";
                        }
                    }))
            },
            async modifyActivity(){
                const response = await axios.put('activities/modify',this.activity);
                this.getAllActivities(1,'','name');
                this.closeModal();
            },
            async openDetail(id){
                this.activities = [];
                let url = `activities/detail?id=${id}`;
                const response = await axios.get(url);
                this.showContent = 2;
                this.activityDetails = response.data;
            },
            desactiveActivity(id,name){
                Swal.fire({
                title: `Esta seguro de cancelar la actividad ${name}?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar!",
                cancelButtonText: "Cancelar!"
                }).then(result => {
                    if (result.value) {
                        axios.put("activities/desactive", { id: id })
                            .then(response => {
                                this.getAllActivities(1,'','name');
                                Swal.fire(
                                    "Cancelado!",
                                    "La actividad ha sido cancelada",
                                    "success"
                                );
                            });
                    }
                });
            },
            activeActivity(id,name){
                Swal.fire({
                title: `Esta seguro de habilitar la actividad ${name}?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar!",
                cancelButtonText: "Cancelar!"
                }).then(result => {
                    if (result.value) {
                        axios.put("activities/active", { id: id })
                            .then(response => {
                                this.getAllActivities(1,'','name');
                                Swal.fire(
                                    "Habilitado!",
                                    "La actividad ha sido habilitada",
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
                        this.modalTitle = "Nueva Actividad";
                        this.modalBtnAction = 1;
                    break;
                    }
                    case 'actualizar':{
                       this.showModal = 1;
                       this.modalTitle = "Actualizar Actividad";
                       this.modalBtnAction = 2;
                       this.activity.attractive_id = data['attractive_id'];
                       this.activity.name = data['name'];
                       this.activity.description = data['description'];
                       this.activity.instructor = data['instructor'];
                       this.activity.cost = data['cost'];
                       this.activity.date_start = data['date_start'];
                       this.activity.date_end = data['date_end'];
                       this.activity.id = data['id'];
                    break;
                    }
               }
               this.selectAttractives();
            },
            closeModal(){
                this.showModal = 0;
                this.modalTitle = '';
                this.activity.attractive_id = '';
                this.activity.name = '';
                this.activity.description = '';
                this.activity.instructor = '';
                this.activity.cost = '';
                this.activity.date_start = '';
                this.activity.date_end = '';
                this.errors = []
           },
           closeDetail(){
               this.showContent=1;
               this.getAllActivities(1,'','name');
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
    .style-chooser .vs__search::placeholder,
    .style-chooser .vs__dropdown-toggle,
    .style-chooser .vs__dropdown-menu {
        background: #dfe5fb;
        border: none;
        color: #394066;
        text-transform: lowercase;
        font-variant: small-caps;
    }

    .style-chooser .vs__clear,
    .style-chooser .vs__open-indicator {
        fill: #394066;
    }
    
</style>