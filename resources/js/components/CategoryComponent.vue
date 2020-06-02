<template>
    <div>
        <form-component :showModal="showModal">
            <template v-slot:title>Administración de Categorias</template>
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
                <form class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="form-control-label" for="name">Nombre</label>
                        <input
                            type="text"
                            id="name"
                            pattern="[A-Za-z]"
                            class="form-control"
                            v-model="category.name"
                            v-has-error="errors.name"
                            :class="[verifyName ? 'is-valid': '']"
                        />
                        <template v-if="verifyName">
                            <div class="valid-feedback">
                                Campo ingresado correctamente
                            </div>                                    
                        </template>
                    </div>
                    <div class="custom-file">
                        <input
                            type="file"
                            class="custom-file-input"
                            id="image"
                            v-has-error="errors.image"
                            
                            @change="getImage($event)"
                        />
                        <template v-if="verifyImage">
                            <div class="valid-feedback">
                                Campo ingresado correctamente
                            </div>                                    
                        </template>
                        <label
                            class="custom-file-label"
                            for="image"
                            :class="[verifyImage ? 'is-valid': '']"
                            >Seleccionar imagen</label
                        >
                    </div>
                    <span
                        v-if="nameFile != ''"
                        class="file-message text-primary"
                        >La imagen seleccionada es: {{ nameFile }}</span
                    >
                </form>
            </template>
            <template v-slot:modal-footer>
                <template v-if="modalBtnAction == 1">
                    <button
                        type="button"
                        class="btn btn-outline-danger"
                        @click="closeModal()"
                    >
                        Cancelar
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="saveCategory()"
                        :disabled="btnDisable"
                    >
                        {{btnText}}
                    </button>
                </template>
                <template v-if="modalBtnAction == 2">
                    <button
                        type="button"
                        class="btn btn-outline-danger"
                        @click="closeModal()"
                    >
                        Cancelar
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="modifyCategory()"
                    >
                        Actualizar
                    </button>
                </template>
            </template>
        </form-component>
        <table-component>
            <template v-slot:card-header>
                <button
                    type="button"
                    class="btn btn-primary"
                    @click="openModal('registrar')"
                >
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
                    @keyup.enter="getAllCategories(1, buscar, criterio)"
                />
                <button
                    type="submit"
                    class="btn btn-primary"
                    @click="getAllCategories(1, buscar, criterio)"
                >
                    <i class="fa fa-search"></i> Buscar
                </button>
            </template>
            <template v-slot:table-header>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Estado</th>
                <th>Opciones</th>
            </template>
            <template v-slot:table-body>
                <tr v-for="category in categories" :key="category.id">
                    <td>{{ category.name }}</td>
                    <td><img :src="`images/categories/${category.image}`" width="40" height="40"/></td>
                    <td><span class="badge badge-success" v-if="category.status == '1'">activo</span>
                        <span class="badge badge-warning" v-if="category.status == '0'">inactivo</span>
                    </td>
                    <td>
                        <button @click="openModal('actualizar', category)" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </button>
                        <template v-if="category.status">
                            <button @click="desactiveCategory(category.id,category.name)" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </template>
                        <template v-else>
                            <button @click="activeCategory(category.id,category.name)" class="btn btn-sm btn-success">
                                <i class="fas fa-check"></i>
                            </button>
                        </template>
                    </td>
                </tr>
            </template>
        </table-component>
        <br />
        <nav>
            <ul class="pagination">
                <li class="page-item" v-if="pagination.current_page > 1">
                    <a
                        class="page-link"
                        href="#"
                        @click.prevent="
                            changePage(
                                pagination.current_page - 1,
                                buscar,
                                criterio
                            )
                        "
                        >Ant</a
                    >
                </li>
                <li
                    class="page-item"
                    v-for="page in pagesNumber"
                    :key="page"
                    :class="[page == isActived ? 'active' : '']"
                >
                    <a
                        class="page-link"
                        href="#"
                        @click.prevent="changePage(page, buscar, criterio)"
                        >{{ page }}</a
                    >
                </li>
                <li
                    class="page-item"
                    v-if="pagination.current_page < pagination.last_page"
                >
                    <a
                        class="page-link"
                        href="#"
                        @click.prevent="
                            changePage(
                                pagination.current_page + 1,
                                buscar,
                                criterio
                            )
                        "
                        >Sig</a
                    >
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    mounted() {
        this.getAllCategories(1, "", "name");
    },
    data() {
        return {
            categories: [],
            errors:[],
            btnDisable:false,
            category: {
                name: "",
                image: null
            },
            nameFile: "",
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
            btnText:'Registrar'
        };
    },
    computed: {
        verifyName() {
            if(this.category.name != ""){
                delete this.errors['name'];
                return true;           
            }else{
                return false;
            }
        },
        verifyImage() {
            if(this.category.image != ""){
                delete this.errors['image'];
                return true;           
            }else{
                return false;
            }
        },
        isActived() {
            return this.pagination.current_page;
        },
        pagesNumber() {
            if (!this.pagination.to) {
                return [];
            }
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
        image() {
            return this.showImage;
        }
    },

    methods: {
        async getAllCategories(page, buscar, criterio) {
            let url = `categories?page=${page}&buscar=${buscar}&criterio=${criterio}`;
            const response = await axios.get(url);
            this.categories = response.data.categories.data;
            this.pagination = response.data.pagination;
        },
        changePage(page, buscar, criterio) {
            //actualiza la pagina actual
            this.pagination.current_page = page;
            //envia la peticion para visualizar la data de la pagina
            this.getAllCategories(page, buscar, criterio);
        },
        getImage(e) {
            let file = e.target.files[0];
            this.nameFile = file.name;
            this.category.image = file;
        },
        saveCategory() {
            this.btnText="Registrando...";
            this.btnDisable=true;
            const data = new FormData();
            data.append("name", this.category.name);
            data.append("image", this.category.image);
            axios.post("categories/save", data)
                .then((response) => {
                    this.errors=[];
                    this.btnDisable=false;
                    this.btnText="Registrar";
                    this.getAllCategories(1, "", "name");
                    this.closeModal();
                }).catch((error) => {
                    if(error.response.status == 422) {
                        this.errors = error.response.data.errors;
                        this.btnDisable=false;
                        this.btnText="Registrar";
                    }
                })
        },
        async modifyCategory() {
            let form = new FormData();
            form.append("id", this.category.id);
            form.append("name", this.category.name);
            form.append("image", this.category.image);
            const response = await axios.post("categories/modify", form);
            this.getAllCategories(1, "", "name");
            this.closeModal();
        },
        desactiveCategory(id,name) {
            Swal.fire({
                title: `Esta seguro de desactivar la categoria ${name}?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar!",
                cancelButtonText: "Cancelar!"
            }).then(result => {
                if (result.value) {
                    axios.put("categories/desactive", { id: id })
                        .then(response => {
                            this.getAllCategories(1, "", "name");
                            Swal.fire(
                                "Desactivado!",
                                "La categoria ha sido desactivado con exito",
                                "success"
                            );
                        });
                }
            });
        },
        activeCategory(id,name) {
            Swal.fire({
                title: `Esta seguro de activar la categoria ${name}?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar!",
                cancelButtonText: "Cancelar!"
            }).then(result => {
                if (result.value) {
                    axios.put("categories/active", { id: id })
                        .then(response => {
                            this.getAllCategories(1, "", "name");
                            Swal.fire(
                                "Activado!",
                                "La categoria ha sido activado con exito",
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
                    this.modalTitle = "Nueva Categoria";
                    this.modalBtnAction = 1;
                    this.nameFile = "";
                    break;
                }
                case "actualizar": {
                    this.showModal = 1;
                    this.modalTitle = "Actualizar Categoria";
                    this.modalBtnAction = 2;
                    this.category.name = data["name"];
                    this.category.image = data["image"];
                    this.category.id = data["id"];
                    break;
                }
            }
        },
        closeModal() {
            this.showModal = 0;
            this.modalTitle = "";
            this.category.name = "", 
            this.category.image = null;
            this.nameFile = "";
            this.errors = [];
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
