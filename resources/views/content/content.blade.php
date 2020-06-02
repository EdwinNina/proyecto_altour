@extends('principal')
@section('content')
    <template v-if="menu == 0">
        <dashboard-component/>
    </template>
    <template v-if="menu == 1">
        <category-component/>
    </template>
    <template v-if="menu == 2">
        <attractive-component/>
    </template>
    <template v-if="menu == 3">
        <activity-component/>
    </template>
    <template v-if="menu == 4">
        <calendar-component/>
    </template>
    <template v-if="menu == 5">
        <user-component/>
    </template>
@endsection