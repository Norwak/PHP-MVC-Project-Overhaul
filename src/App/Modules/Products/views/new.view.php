{% extends "Common/views/base.view.php" %}

{% block title %}New Product{% endblock %}

{% block body %}

<h1>New Product</h1>

<form method="POST" action="/products/create">

  {% include "Modules/Products/views/form.view.php" %}

</form>

{% endblock %}