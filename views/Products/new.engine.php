{% extends "base.engine.php" %}

{% block title %}New Product{% endblock %}

{% block body %}

<h1>New Product</h1>

<form method="POST" action="/products/create">

  {% include "Products/form.engine.php" %}

</form>

{% endblock %}