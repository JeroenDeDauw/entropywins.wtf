{% extends "layout.html" %}

{% block title %}Slides{% endblock %}

{% block content %}

{% markdown %}



{% endmarkdown %}

<style>
    /* http://www.mademyday.de/css-height-equals-width-with-pure-css.html? */
    .box{
        position: relative;
        width: 100%;
        background-color: darkblue;
    }
    .box:before{
        content: "";
        display: block;
        padding-top: 56.25%;
    }

    .content{
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
    }
</style>

<div class='box'>
    <iframe class='content' src="http://jeroendedauw.github.io/slides/craftmanship/functions/" width="100%" height="100%"></iframe>
</div>

{% endblock %}
