<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><slot name="title"/></h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><slot name="title"/></li>
            </ol>
        </div>
        <div class="modal fade" :class="{'mostrar':showModal}" id="exampleModal" style="display:none" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <slot name="modal-header"/>
                    </div>
                    <div class="modal-body">
                        <slot name="modal-body"/>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <slot name="modal-footer"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
      props:['showModal']  
    }
</script>

<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
        margin-top: 3em;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }

</style>