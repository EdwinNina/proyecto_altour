@extends('principal')
@section('content')
    <template v-if="menu == 0">
        <dashboard-component/>
    </template>
    <template v-if="menu == 1">
        <category-component/>
    </template>
@endsection