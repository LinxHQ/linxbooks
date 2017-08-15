<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$list = array('expenses_category');
$model = new UserList();

$model->insertList($list[0]);
$list_recurring = array('recurring');
$model = new UserList();

$model->insertList($list_recurring[0]);
