<template>
    <div>
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Administración</h1>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="./">Inicio</a></li>
				<li class="breadcrumb-item active" aria-current="page">Administración</li>
			</ol>
		</div>
		<div class="row mb-3">
			<!-- Earnings (Monthly) Card Example -->
			<div class="col-xl-4 col-md-6 mb-4">
				<div class="card h-100">
				<div class="card-body">
					<div class="row align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-uppercase mb-1">Categorias</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">{{countCategories}}</div>
						<div class="mt-2 mb-0 text-muted text-xs">
						</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-calendar fa-2x text-primary"></i>
					</div>
					</div>
				</div>
				</div>
			</div>
			<!-- Earnings (Annual) Card Example -->
			<div class="col-xl-4 col-md-6 mb-4">
				<div class="card h-100">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-uppercase mb-1">Atractivos</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">{{countAttractives}}</div>
						<div class="mt-2 mb-0 text-muted text-xs">
						</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-shopping-cart fa-2x text-success"></i>
					</div>
					</div>
				</div>
				</div>
			</div>
			<!-- New User Card Example -->
			<div class="col-xl-4 col-md-6 mb-4">
				<div class="card h-100">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-uppercase mb-1">Actividades</div>
						<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{countAttractives}}</div>
						<div class="mt-2 mb-0 text-muted text-xs">
						</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-users fa-2x text-info"></i>
					</div>
					</div>
				</div>
				</div>
			</div>
		</div>
    </div>
</template>

<script>
    export default {
		mounted () {
			this.getAllData();
		},
        data() {
			return {
				countAttractives: null,
				countActivities: null,
				countCategories: null
			}
		},
		methods: {
			async getAllData() {
				const response = await axios.get('dashboard');
				this.countActivities = response.data.activities;
				this.countAttractives = response.data.attractives;
				this.countCategories = response.data.categories;
			}
		},
    }
</script>

<style lang="scss" scoped>

</style>