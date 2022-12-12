<?php

/* Dashboard
|-------------------------------------------------------------------------- */
Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push('Página Inicial', route('admin.dashboard'));
});

/* Profile
|-------------------------------------------------------------------------- */
Breadcrumbs::for('admin.profile.edit', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Meu Perfil', route('admin.profile.edit'));
});

Breadcrumbs::for('admin.profile.update', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Meu Perfil', route('admin.profile.update'));
});

/* Change password
|-------------------------------------------------------------------------- */
Breadcrumbs::for('admin.password.edit', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Alterar Senha', route('admin.password.edit'));
});

Breadcrumbs::for('admin.password.update', function ($trail) {
    $trail->parent('admin.profile.edit');
    $trail->push('Alterar Senha', route('admin.password.update'));
});

/* Users resources
|-------------------------------------------------------------------------- */
Breadcrumbs::for('admin.users', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Administradores', route('admin.users'));
});

Breadcrumbs::for('admin.search.users', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Administradores', route('admin.users'));
});

Breadcrumbs::for('admin.show.user', function ($trail, $id) {
    $trail->parent('admin.users');
    $trail->push('Administrador #'.$id , route ('admin.show.user', $id));
});

Breadcrumbs::for('admin.edit.user', function ($trail, $id) {
    $trail->parent('admin.users', $id);
    $trail->push('Editar Administrador #'.$id, route('admin.edit.user', $id));
});

Breadcrumbs::for('admin.update.user', function ($trail, $id) {
    $trail->parent('admin.users');
    $trail->push('Editar Administrador', route('admin.update.user', $id));
});

Breadcrumbs::for('admin.new.user', function ($trail) {
    $trail->parent('admin.users');
    $trail->push('Novo Administrador', route('admin.new.user'));
});

Breadcrumbs::for('admin.create.user', function ($trail) {
    $trail->parent('admin.users');
    $trail->push('Novo Administrador', route('admin.create.user'));
});

/* Servants resources
|-------------------------------------------------------------------------- */
Breadcrumbs::for('admin.servants', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Servidores', route('admin.servants'));
});

Breadcrumbs::for('admin.servants.page', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Servidores', route('admin.servants'));
});

Breadcrumbs::for('admin.search.servants', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Servidores', route('admin.servants'));
});

Breadcrumbs::for('admin.search.servants.page', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Servidores', route('admin.servants'));
});

Breadcrumbs::for('admin.show.servant', function ($trail, $id) {
    $trail->parent('admin.servants');
    $trail->push('Servidor #'.$id , route ('admin.show.servant', $id));
});

/* Edicts resources
|-------------------------------------------------------------------------- */
Breadcrumbs::for('admin.edicts', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Editais', route('admin.edicts'));
});

Breadcrumbs::for('admin.create.edict', function ($trail) {
    $trail->parent('admin.edicts');
    $trail->push('Novo Edital', route('admin.new.edict'));
});

Breadcrumbs::for('admin.new.edict', function ($trail) {
    $trail->parent('admin.edicts');
    $trail->push('Novo Edital', route('admin.new.edict'));
});

Breadcrumbs::for('admin.search.edicts', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Editais', route('admin.edicts'));
});

Breadcrumbs::for('admin.show.edict', function ($trail, $id) {
    $trail->parent('admin.edicts');
    $trail->push('Edital #'.$id , route ('admin.show.edict', $id));
});

Breadcrumbs::for('admin.edit.edict', function ($trail, $id) {
    $trail->parent('admin.edicts', $id);
    $trail->push('Editar Edital #'.$id, route('admin.edit.edict', $id));
});

Breadcrumbs::for('admin.update.edict', function ($trail, $id) {
    $trail->parent('admin.edicts');
    $trail->push('Editar Edital', route('admin.update.edict', $id));
});

Breadcrumbs::for('admin.edicts.page', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Editais', route('admin.edicts'));
});

Breadcrumbs::for('admin.search.edicts.page', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Editais', route('admin.edicts'));
});

Breadcrumbs::for('admin.classifications', function ($trail, $id) {
    $trail->parent('admin.edicts');
    $trail->push('Classificação do Edital #'. $id, route('admin.classifications', $id));
});

Breadcrumbs::for('admin.update.classifications', function ($trail, $id) {
    $trail->parent('admin.edicts');
    $trail->push('Atualizar Classificação', route('admin.update.classifications', $id));
});

Breadcrumbs::for('admin.new.vacant_unit', function ($trail, $id) {
    $trail->parent('admin.edicts');
    $trail->push('Cadastro de vagas por unidade Edital #'.$id, route('admin.new.vacant_unit', $id));
});

Breadcrumbs::for('admin.create.vacant_unit', function ($trail, $id) {
    $trail->parent('admin.edicts');
    $trail->push('Cadastro de vagas por unidade Edital #'.$id, route('admin.new.vacant_unit', $id));
});

/* Pdfs Edict
|-------------------------------------------------------------------------- */
Breadcrumbs::for('admin.index.pdf', function ($trail, $id) {
    $trail->parent('admin.edicts');
    $trail->push('Novo PDF', route('admin.index.pdf', $id));
});

Breadcrumbs::for('admin.create.pdf', function ($trail, $id) {
    $trail->parent('admin.edicts');
    $trail->push('Novo PDF', route('admin.create.pdf', $id));
});

/* Dashboard Servant
|-------------------------------------------------------------------------- */
Breadcrumbs::for('servant.dashboard', function ($trail) {
    $trail->push('Página Inicial', route('servant.dashboard'));
});

/* Profile
|-------------------------------------------------------------------------- */
Breadcrumbs::for('servant.profile.edit', function ($trail) {
    $trail->parent('servant.dashboard');
    $trail->push('Meu Perfil', route('servant.profile.edit'));
});

Breadcrumbs::for('servant.profile.update', function ($trail) {
    $trail->parent('servant.dashboard');
    $trail->push('Meu Perfil', route('servant.profile.update'));
});

/* Change password
|-------------------------------------------------------------------------- */
Breadcrumbs::for('servant.password.edit', function ($trail) {
    $trail->parent('servant.dashboard');
    $trail->push('Alterar Senha', route('servant.password.edit'));
});

Breadcrumbs::for('servant.profile.password.update', function ($trail) {
    $trail->parent('servant.profile.edit');
    $trail->push('Alterar Senha', route('servant.profile.password.update'));
});

/* Category of Units
|-------------------------------------------------------------------------- */
Breadcrumbs::for('admin.unit_categories', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Categorias de Unidades', route('admin.unit_categories'));
});

Breadcrumbs::for('admin.new.unit_category', function ($trail) {
    $trail->parent('admin.unit_categories');
    $trail->push('Nova Categoria', route('admin.new.unit_category'));
});

Breadcrumbs::for('admin.create.unit_category', function ($trail) {
    $trail->parent('admin.unit_categories');
    $trail->push('Nova Categoria', route('admin.create.unit_category'));
});

Breadcrumbs::for('admin.search.unit_categories', function ($trail) {
    $trail->parent('admin.unit_categories');
    $trail->push('Buscar Categorias', route('admin.search.unit_categories'));
});

Breadcrumbs::for('admin.edit.unit_category', function ($trail, $id) {
    $trail->parent('admin.unit_categories');
    $trail->push('Editar Categoria #'.$id, route('admin.edit.unit_category', $id));
});

Breadcrumbs::for('admin.update.unit_category', function ($trail, $id) {
    $trail->parent('admin.unit_categories');
    $trail->push('Editar Categoria #'.$id, route('admin.edit.unit_category', $id));
});

Breadcrumbs::for('admin.unit_categories.page', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Categorias', route('admin.unit_categories'));
});

Breadcrumbs::for('admin.search.unit_categories.page', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Categorias', route('admin.unit_categories'));
});


/* Units
|-------------------------------------------------------------------------- */
Breadcrumbs::for('admin.units', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Unidades', route('admin.units'));
});

Breadcrumbs::for('admin.new.unit', function ($trail) {
    $trail->parent('admin.units');
    $trail->push('Nova Unidade', route('admin.new.unit'));
});

Breadcrumbs::for('admin.search.units', function ($trail) {
    $trail->parent('admin.units');
    $trail->push('Buscar Unidades', route('admin.search.units'));
});

Breadcrumbs::for('admin.edit.unit', function ($trail, $id) {
    $trail->parent('admin.units');
    $trail->push('Editar Unidade #'.$id, route('admin.edit.unit', $id));
});

Breadcrumbs::for('admin.update.unit', function ($trail, $id) {
    $trail->parent('admin.units');
    $trail->push('Editar Unidade #'.$id, route('admin.update.unit', $id));
});

Breadcrumbs::for('admin.create.unit', function ($trail) {
    $trail->parent('admin.units');
    $trail->push('Nova Unidade', route('admin.create.unit'));
});

Breadcrumbs::for('admin.show.unit', function ($trail, $id) {
    $trail->parent('admin.units');
    $trail->push('Unidade #'.$id, route('admin.show.unit', $id));
});

Breadcrumbs::for('admin.units.page', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Unidades', route('admin.units'));
});

Breadcrumbs::for('admin.search.units.page', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Unidades', route('admin.units'));
});

/* Inscription of Edicts
|---------------------------------------------------------------------------*/
Breadcrumbs::for('admin.inscriptions', function ($trail, $id) {
    $trail->parent('admin.edicts');
    $trail->push('Inscrições no Edital #'. $id, route('admin.inscriptions', $id));
});

Breadcrumbs::for('admin.show.inscription', function ($trail, $edict, $id) {
    $trail->parent('admin.inscriptions', $edict);
    $trail->push('Inscrição #'. $id, route('admin.show.inscription', ['edict_id'=> $edict, 'id' => $id]));
});

/* Servant Inscrptions
|-------------------------------------------------------------------------- */
Breadcrumbs::for('servant.new.inscription', function ($trail, $id) {
    $trail->parent('servant.show.edict', $id);
    $trail->push('Nova Inscrição', route('servant.new.inscription' , $id));
});

Breadcrumbs::for('servant.create.inscription', function ($trail, $id) {
    $trail->parent('servant.show.edict', $id);
    $trail->push('Nova Inscrição', route('servant.create.inscription' , $id));
});

Breadcrumbs::for('servant.inscriptions', function ($trail) {
    $trail->parent('servant.dashboard');
    $trail->push('Minhas Inscrições', route('servant.inscriptions'));
});

Breadcrumbs::for('servant.show.inscription', function ($trail, $id) {
    $trail->parent('servant.inscriptions');
    $trail->push('Inscrição #'. $id, route('servant.show.inscription', $id));
});

/* Edicts Servant
|-------------------------------------------------------------------------- */

Breadcrumbs::for('servant.edicts', function ($trail) {
    $trail->parent('servant.dashboard');
    $trail->push('Editais Abertos', route('servant.edicts'));
});

Breadcrumbs::for('servant.show.edict', function ($trail, $id) {
    $trail->parent('servant.edicts');
    $trail->push('Edital #' .$id, route('servant.show.edict', $id));
});

Breadcrumbs::for('servant.edicts.page', function ($trail, $term) {
    $trail->parent('servant.dashboard');
    $trail->push('Editais Abertos', route('servant.edicts.page', $term));
});

Breadcrumbs::for('servant.edicts.close', function ($trail) {
    $trail->parent('servant.dashboard');
    $trail->push('Editais Fechados', route('servant.edicts.close'));
});

Breadcrumbs::for('servant.edicts.close.page', function ($trail, $term) {
    $trail->parent('servant.dashboard');
    $trail->push('Editais Fechados', route('servant.edicts.close.page', $term));
});

Breadcrumbs::for('servant.search.edicts', function ($trail) {
    $trail->parent('servant.dashboard');
    $trail->push('Editais Abertos', route('servant.search.edicts'));
});

Breadcrumbs::for('servant.search.edicts.close', function ($trail) {
    $trail->parent('servant.dashboard');
    $trail->push('Editais Fechados', route('servant.search.edicts.close'));
});

/* Servant Completary Data
|-------------------------------------------------------------------------- */

Breadcrumbs::for('admin.index.completary_data', function ($trail, $id) {
     $trail->parent('admin.show.servant', $id);
    $trail->push('Cadastro Complementar', route('admin.index.completary_data', $id));
});

Breadcrumbs::for('admin.index.completary_datas', function ($trail, $servant_id, $id) {
     $trail->parent('admin.index.completary_data', $servant_id, $id);
    $trail->push('Dados Complementares', route('admin.index.completary_datas', ['servant_id' => $servant_id, 'id' => $id]));
});

Breadcrumbs::for('admin.new.completary_data', function ($trail, $servant_id, $id) {
    $trail->parent('admin.index.completary_datas', $servant_id, $id);
    $trail->push('Criar Cadastro Complementar', route('admin.new.completary_data', ['servant_id' => $servant_id, 'id' => $id]));
});

Breadcrumbs::for('admin.create.completary_data', function ($trail, $servant_id, $id) {
    $trail->parent('admin.index.completary_datas', $servant_id, $id);
    $trail->push('Criar Cadastro Complementar', route('admin.create.completary_data', ['servant_id' => $servant_id, 'id' => $id]));
});

Breadcrumbs::for('admin.edit.completary_data', function ($trail, $servant_id, $contract_id, $completary_data) {
    $trail->parent('admin.index.completary_datas', $servant_id, $contract_id);
    $trail->push('Editar Cadastro Complementar #'. $completary_data, route('admin.edit.completary_data', ['servant_id' => $servant_id, 'contract_id' => $contract_id, 'id' => $completary_data]));
});

Breadcrumbs::for('admin.update.completary_data', function ($trail, $servant_id, $contract_id, $completary_data) {
      $trail->parent('admin.index.completary_datas', $servant_id, $contract_id);
    $trail->push('Editar Cadastro Complementar #'. $completary_data, route('admin.update.completary_data', ['servant_id' => $servant_id, 'contract_id' => $contract_id, 'id' => $completary_data]));
});

/* Movement
|-------------------------------------------------------------------------- */

Breadcrumbs::for('admin.new.movement', function ($trail, $servant_id, $contract_id, $id) {
     $trail->parent('admin.index.completary_datas', $servant_id, $contract_id);
    $trail->push('Nova Movimentação', route('admin.new.movement', ['servant_id' => $servant_id, 'contract_id' => $contract_id, 'id' => $id]));
});

Breadcrumbs::for('admin.create.movement', function ($trail, $servant_id, $contract_id, $id) {
     $trail->parent('admin.index.completary_datas', $servant_id, $contract_id);
    $trail->push('Nova Movimentação', route('admin.create.movement', ['servant_id' => $servant_id, 'contract_id' => $contract_id, 'id' => $id]));
});

Breadcrumbs::for('admin.edit.movement', function ($trail, $servant_id, $contract_id, $completaryData_id, $id) {
    $trail->parent('admin.index.completary_datas', $servant_id, $contract_id);
    $trail->push('Editar Movimentação #'. $id, route('admin.edit.movement', ['servant_id' => $servant_id, 'contract_id' => $contract_id, 'completaryData_id' => $completaryData_id, 'id' => $id]));
});

Breadcrumbs::for('admin.update.movement', function ($trail, $servant_id, $contract_id, $completaryData_id, $id) {
    $trail->parent('admin.index.completary_datas', $servant_id, $contract_id);
    $trail->push('Editar Movimentação #'. $id, route('admin.edit.movement', ['servant_id' => $servant_id, 'contract_id' => $contract_id, 'completaryData_id' => $completaryData_id, 'id' => $id]));
});
