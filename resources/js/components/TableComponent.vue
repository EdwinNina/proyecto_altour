<template>
    <div class="card">
        <div class="card-header">
            <slot name="card-header"/>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="input-group">
                        <slot name="card-search"/>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped align-items-center">
                    <thead class="text-center">
                        <tr>
                            <slot name="table-header"/>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <slot name="table-body"/>
                    </tbody>
                </table>
            </div>
            <br>
        </div>
    </div>
</template>

<script>
    export default {
        
    }
</script>

<style lang="scss" scoped>

</style>