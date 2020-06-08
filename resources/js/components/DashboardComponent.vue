<template>
    <div>
		<div class="page-header">
			<h3 class="page-title">
				<span class="page-title-icon bg-gradient-primary text-white mr-2">
				<i class="mdi mdi-home"></i>
				</span> Administracion Principal </h3>
		</div>
		<div class="row">
			<div class="col-md-3 stretch-card grid-margin">
				<div class="card bg-gradient-danger card-img-holder text-white">
				<div class="card-body">
					<img src="img/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
					<h4 class="font-weight-normal mb-3">Categorias <i class="mdi mdi-chart-line mdi-24px float-right"></i>
					</h4>
					<h2 class="mb-5">{{countCategories}}</h2>
				</div>
				</div>
			</div>
			<div class="col-md-3 stretch-card grid-margin">
				<div class="card bg-gradient-info card-img-holder text-white">
				<div class="card-body">
					<img src="img/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
					<h4 class="font-weight-normal mb-3">Atractivos <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
					</h4>
					<h2 class="mb-5">{{countAttractives}}</h2>
				</div>
				</div>
			</div>
			<div class="col-md-3 stretch-card grid-margin">
				<div class="card bg-gradient-warning card-img-holder text-white">
				<div class="card-body">
					<img src="img/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
					<h4 class="font-weight-normal mb-3">Actividades <i class="mdi mdi-diamond mdi-24px float-right"></i>
					</h4>
					<h2 class="mb-5">{{countActivities}}</h2>
				</div>
				</div>
			</div>
			<div class="col-md-3 stretch-card grid-margin">
				<div class="card bg-gradient-success card-img-holder text-white">
				<div class="card-body">
					<img src="img/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
					<h4 class="font-weight-normal mb-3">Personas registradas en la App <i class="mdi mdi-diamond mdi-24px float-right"></i>
					</h4>
					<h2 class="mb-5">{{countTourists}}</h2>
				</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-sm-12 stretch-card grid-margin">
				<div class="card">
					<div class="card-body">
						<canvas id="likes"></canvas>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12 stretch-card grid-margin">
				<div class="card">
					<div class="card-body">
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
				countCategories: null,
				countTourists: null,
				likesData:[],
				totalDataChart:[],
				labelDataChart:[],
				likesCanva: null,
				likesChar: null
			}
		},
		methods: {
			async getAllData() {
				const response = await axios.get('dashboard/cards');
				const responseChart = await axios.get('dashboard/charts');
				this.countActivities = response.data.activities;
				this.countAttractives = response.data.attractives;
				this.countCategories = response.data.categories;
				this.countTourists = response.data.tourists;
				this.likesData = responseChart.data;
				this.loadDataChart();
			},
			loadDataChart(){
				this.likesData.map(data => {
					this.totalDataChart.push(data.mount);
					this.labelDataChart.push(data.name);
				});

				this.likesCanva = document.getElementById('likes').getContext('2d');
				this.likesChar = new Chart(this.likesCanva, {
					type: 'bar',
					data: {
						labels: this.labelDataChart,
						datasets: [{
							label: 'Me gusta',
							data: this.totalDataChart,
							backgroundColor: [
								'rgba(255, 99, 132, 0.2)',
								'rgba(54, 162, 235, 0.2)',
								'rgba(255, 206, 86, 0.2)',
								'rgba(75, 192, 192, 0.2)',
								'rgba(153, 102, 255, 0.2)',
								'rgba(255, 159, 64, 0.2)'
							],
							borderColor: [
								'rgba(255, 99, 132, 1)',
								'rgba(54, 162, 235, 1)',
								'rgba(255, 206, 86, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(153, 102, 255, 1)',
								'rgba(255, 159, 64, 1)'
							],
						}]
					},
					options: {
						scales: {
								yAxes: [{
									ticks: {
										beginAtZero: true
									}
								}]
						}
					}
				});
			}
		}
	}
</script>