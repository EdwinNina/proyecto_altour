<template>
   <div>
      <full-calendar :events="activities" :monthNames="month" :weekNames="week" locale="es"/>
   </div>
</template>

<script>
   export default {
      mounted(){
         this.getActivities();
      },
      data() {
         return {
            activities:[]
         }
      },
      computed: {
         month() {
            return ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
         },
         week(){
            return ['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'];
         }
      },
      methods: {
         async getActivities() {
            const response = await axios.get('activities/select');
            this.activities = response.data;
         },
      },
   }
</script>

<style lang="scss" scoped>

</style>