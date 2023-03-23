@extends('layouts.base')
@section('body')


<style>
    @import url("https://fonts.googleapis.com/css?family=Roboto+Condensed:700");

    html {
        height: 100%;
    }

    body {
        min-height: 100%;
        background-color: #111111;
        font-family: "Roboto Condensed" !important;
        text-transform: uppercase;
        overflow: hidden;
    }

    .police-tape {
        background-color: #e2bb2d;
        background: linear-gradient(180deg, #eed887 0%, #e2bb2d 5%, #e2bb2d 90%, #e5c243 95%, #0e0b02 100%);
        padding: 0.125em;
        font-size: 3em;
        text-align: center;
        white-space: nowrap;
    }

    .police-tape--1 {
        transform: rotate(10deg);
        position: absolute;
        top: 40%;
        left: -5%;
        right: -5%;
        z-index: 2;
        margin-top: 0;
    }

    .police-tape--2 {
        transform: rotate(-8deg);
        position: absolute;
        top: 50%;
        left: -5%;
        right: -5%;
    }

    .ghost {
        display: flex;
        justify-content: stretch;
        flex-direction: column;
        height: 100vh;
    }

    .ghost--columns {
        display: flex;
        flex-grow: 1;
        flex-basis: 200px;
        align-content: stretch;
    }

    .ghost--navbar {
        flex: 0 0 60px;
        background: linear-gradient(0deg, #27292d 0px, #27292d 10px, transparent 10px);
        border-bottom: 2px solid #111111;
    }

    .ghost--column {
        flex: 1 0 30%;
        border-width: 0px;
        border-style: solid;
        border-color: #27292d;
        border-left-width: 10px;
        background-color: #191a1d;
    }

    .ghost--column:nth-child(1) .code:nth-child(1) {
        margin-left: 3em;
    }

    .ghost--column:nth-child(1) .code:nth-child(2) {
        margin-left: 3.5em;
    }

    .ghost--column:nth-child(1) .code:nth-child(3) {
        margin-left: 4em;
    }

    .ghost--column:nth-child(1) .code:nth-child(4) {
        margin-left: 4em;
    }

    .ghost--column:nth-child(2) .code:nth-child(1) {
        margin-left: 4.5em;
    }

    .ghost--column:nth-child(2) .code:nth-child(2) {
        margin-left: 2em;
    }

    .ghost--column:nth-child(2) .code:nth-child(3) {
        margin-left: 3em;
    }

    .ghost--column:nth-child(2) .code:nth-child(4) {
        margin-left: 1.5em;
    }

    .ghost--column:nth-child(3) .code:nth-child(1) {
        margin-left: 5.5em;
    }

    .ghost--column:nth-child(3) .code:nth-child(2) {
        margin-left: 5.5em;
    }

    .ghost--column:nth-child(3) .code:nth-child(3) {
        margin-left: 1.5em;
    }

    .ghost--column:nth-child(3) .code:nth-child(4) {
        margin-left: 4.5em;
    }

    .ghost--main {
        background-color: #111111;
        border-top: 15px solid #303338;
        flex: 1 0 100px;
    }

    .code {
        display: block;
        width: 100px;
        background-color: #27292d;
        height: 1em;
        margin: 1em;
    }

    .ghost--main .code {
        height: 2em;
        width: 200px;
    }
</style>
<div class="ghost">

    <div class="ghost--navbar"></div>
    <div class="ghost--columns">
        <div class="ghost--column">
            <div class="code"></div>
            <div class="code"></div>
            <div class="code"></div>
            <div class="code"></div>
        </div>
        <div class="ghost--column">
            <div class="code"></div>
            <div class="code"></div>
            <div class="code"></div>
            <div class="code"></div>
        </div>
        <div class="ghost--column">
            <div class="code"></div>
            <div class="code"></div>
            <div class="code"></div>
            <div class="code"></div>
        </div>

    </div>
    <div class="ghost--main">
        <div class="code"></div>
        <div class="code"></div>

    </div>

</div>

<h1 class="police-tape police-tape--1">
    &nbsp;&nbsp;&nbsp;&nbsp;Error: 403&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Error:
    403&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Error: 403&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Error:
    403&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Error: 403&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Error:
    403&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Error: 403
</h1>
<h1 class="police-tape police-tape--2">
    Forbidden&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Forbidden&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Forbidden&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Forbidden&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Forbidden&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Forbidden&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</h1>


@endsection