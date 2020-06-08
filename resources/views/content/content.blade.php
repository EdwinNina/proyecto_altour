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
        <place-component/>
    </template>
    <template v-if="menu == 4">
        <activity-component/>
    </template>
    <template v-if="menu == 5">
        <calendar-component/>
    </template>
    <template v-if="menu == 6">
        <tourist-component/>
    </template>
    <template v-if="menu == 7">
        <user-component/>
    </template>
    <template v-if="menu == 8">
        <role-component/>
    </template>
@endsection