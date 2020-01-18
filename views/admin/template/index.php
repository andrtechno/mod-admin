<?php
use panix\engine\Html;

$this->registerJs("

        $(window).resize(function () {
            var h = Math.max($(window).height() - 0, 420);
            $('#data, #tree, #data .contentTree').height(h).filter('.default').css('lineHeight', h + 'px');
        }).resize();

        $('#tree').jstree({
            'core': {
                'data': {
                    'url': '/admin/app/template/operation?operation=get_node',
                    'data': function (node) {
                        return {'id': node.id};
                    }
                },
                'check_callback': function (o, n, p, i, m) {
                    if (m && m.dnd && m.pos !== 'i') {
                        return false;
                    }
                    if (o === 'move_node' || o === 'copy_node') {
                        if (this.get_node(n).parent === this.get_node(p).id) {
                            return false;
                        }
                    }
                    return true;
                },
                'themes': {
                    'responsive': true,
                    'variant': 'large',
                    'stripes': true
                }
            },
            'sort': function (a, b) {
                return this.get_type(a) === this.get_type(b) ? (this.get_text(a) > this.get_text(b) ? 1 : -1) : (this.get_type(a) >= this.get_type(b) ? 1 : -1);
            },
            'contextmenu': {
                'items': function (node) {
                    var tmp = $.jstree.defaults.contextmenu.items();
                    console.log(tmp);
                    delete tmp.create.action;
                    tmp.remove.label = '".Yii::t('app/default','DELETE')."';
                    tmp.remove.icon = 'icon-delete';
                    tmp.rename.label = '".Yii::t('app/default','RENAME')."';
                    tmp.rename.icon = 'icon-rename';
                    tmp.ccp.label = '".Yii::t('app/default','UPDATE')."';
                    tmp.ccp.icon = 'icon-edit';
                    tmp.ccp.submenu.copy.icon = 'icon-copy';
                    tmp.ccp.submenu.cut.icon = 'icon-cut';
                    tmp.ccp.submenu.paste.icon = 'icon-paste';
                    
                    
                    
                    tmp.create.label = 'Создать';
                    tmp.create.icon = 'icon-add';
                    tmp.create.submenu = {
                        'create_folder': {
                            //'separator_after': true,
                            'label': 'Папку',
                            'icon':'icon-folder-open',
                            'action': function (data) {
                                var inst = $.jstree.reference(data.reference),
                                    obj = inst.get_node(data.reference);
                                inst.create_node(obj, {type: 'default'}, 'last', function (new_node) {
                                    setTimeout(function () {
                                        inst.edit(new_node);
                                    }, 0);
                                });
                            }
                        },
                        'create_file': {
                            'label': 'Файл',
                            'icon':'icon-file-doc',
                            'action': function (data) {
                                var inst = $.jstree.reference(data.reference),
                                    obj = inst.get_node(data.reference);
                                inst.create_node(obj, {type: 'file'}, 'last', function (new_node) {
                                    setTimeout(function () {
                                        inst.edit(new_node);
                                    }, 0);
                                });
                            }
                        }
                    };
                    if (this.get_type(node) === 'file') {
                        delete tmp.create;
                    }
                    return tmp;
                }
            },
            'types': {
                'default': {'icon': 'folder icon-folder-open'},
                'file': {'valid_children': [], 'icon': 'file icon-file-doc'}
            },
            'unique': {
                'duplicate': function (name, counter) {
                    return name + ' ' + counter;
                }
            },
            'plugins': ['state', 'dnd', 'sort', 'types', 'contextmenu', 'unique']
        })
            .on('delete_node.jstree', function (e, data) {
                $.get(common.url('/admin/app/template/operation?operation=delete_node'), {'id': data.node.id})
                    .fail(function () {
                        data.instance.refresh();
                    });
            })
            .on('create_node.jstree', function (e, data) {
                $.get(common.url('/admin/app/template/operation?operation=create_node'), {'type': data.node.type, 'id': data.node.parent, 'text': data.node.text})
                    .done(function (d) {
                        data.instance.set_id(data.node, d.id);
                    })
                    .fail(function () {
                        data.instance.refresh();
                    });
            })
            .on('rename_node.jstree', function (e, data) {
                $.get(common.url('/admin/app/template/operation?operation=rename_node'), {'id': data.node.id, 'text': data.text})
                    .done(function (d) {
                        data.instance.set_id(data.node, d.id);
                    })
                    .fail(function () {
                        data.instance.refresh();
                    });
            })
            .on('move_node.jstree', function (e, data) {
                $.get(common.url('/admin/app/template/operation?operation=move_node'), {'id': data.node.id, 'parent': data.parent})
                    .done(function (d) {
                        //data.instance.load_node(data.parent);
                        data.instance.refresh();
                    })
                    .fail(function () {
                        data.instance.refresh();
                    });
            })
            .on('copy_node.jstree', function (e, data) {
                $.get(common.url('/admin/app/template/operation?operation=copy_node'), {'id': data.original.id, 'parent': data.parent})
                    .done(function (d) {
                        //data.instance.load_node(data.parent);
                        data.instance.refresh();
                    })
                    .fail(function () {
                        data.instance.refresh();
                    });
            })
            .on('changed.jstree', function (e, data) {
                if (data && data.selected && data.selected.length) {
                    $.get('/admin/app/template/operation?operation=get_content&id=' + data.selected.join(':'), function (d) {
                        if (d && typeof d.type !== 'undefined') {
                            $('#filename').val(data.selected.join(':'));
                            $('#data .contentTree').hide();

                            
                            
                            var mode = 'application/x-httpd-php';
                            if(d.type == 'js'){
                                mode = 'javascript';
                            } else if (d.type == 'css'){
                               mode = 'text/css';
                            } else if(d.type == 'html'){
                                mode = 'application/x-httpd-php';
                            } else if (d.type == 'scss'){
                                mode = 'text/x-scss';
                            }
                    
                            $('.CodeMirror').remove();
                            switch (d.type) {
                                case 'text':
                                case 'txt':
                                case 'md':
                                case 'htaccess':
                                case 'log':
                                case 'sql':
                                case 'js':
                                case 'json':
                                case 'scss':
                                    $('#data .code').show();
                                    var cm = CodeMirror.fromTextArea(document.getElementById('code'), {
                                        mode: mode,
                                        theme:'ambiance',
                                        lineNumbers: true,
                                        lineWrapping: true,
                                        matchBrackets: true,
                                        indentUnit: 4,
                                        indentWithTabs: true,
                                        enterMode: 'keep',
                                        tabMode: 'shift',
                                        readOnly: d.readonly
                                    });
                                    cm.setValue(d.content);
                                    cm.setSize('100%', '100%');
                                    break;
                                case 'css':

                                    $('#data .code').show();
                                    //$('#code').html(d.content).attr('readonly', d.readonly);
                                    var cm = CodeMirror.fromTextArea(document.getElementById('code'), {
                                        mode: mode,
                                        theme:'ambiance',
                                        lineNumbers: true,
                                        lineWrapping: true,
                                        matchBrackets: true,
                                        indentUnit: 4,
                                        indentWithTabs: true,
                                        enterMode: 'keep',
                                        tabMode: 'shift',
                                        readOnly: d.readonly
                                    });
                                    cm.setValue(d.content);
                                    cm.setSize('100%', '100%');
                                    //cm.refresh();
                                    break;
                                case 'php':
                                    $('#data .code').show();
                                    var editorConfig = {
                                        mode: mode,
                                        theme:'ambiance',
                                        lineNumbers: true,
                                        lineWrapping: true,
                                        styleActiveLine: true,
                                        matchBrackets: true,
                                        indentUnit: 10,
                                        indentWithTabs: true,
                                        enterMode: 'keep',
                                        tabMode: 'shift',
                                        readOnly: d.readonly,
                                    };
                                    var cm = CodeMirror.fromTextArea(document.getElementById('code'), editorConfig);
                                    cm.setValue(d.content);
                                    cm.setSize('100%', '100%');
                                    //cm.refresh();
                                    break;
                                case 'svg':
                                case 'html':
                                    $('#data .code').show();
                                    $('#code').val(d.content).attr('readonly', d.readonly);
                                    break;
                                case 'ico':
                                case 'png':
                                case 'jpg':
                                case 'jpeg':
                                case 'bmp':
                                case 'gif':
                                    $('#data .image img').one('load', function () {
                                        $(this).css({'marginTop': '-' + $(this).height() / 2 + 'px', 'marginLeft': '-' + $(this).width() / 2 + 'px'});
                                    }).attr('src', d.content);
                                    $('#data .image').show();
                                    break;
                                default:
                                    $('#data .default').html(d.content).show();
                                    break;
                            }
                        }
                    });
                } else {
                    //$('#data .contentTree').hide();
                    $('#data .default').html('Select a file from the tree.').show();
                }
            });

");


\panix\ext\jstree\FileBrowser::widget([]);

?>










<?= Html::beginForm() ?>
<?= Html::hiddenInput('file', null, ['id' => 'filename']) ?>
<div class="row">
    <div class="col-sm-5 col-md-4">
        <div id="tree"></div>
    </div>
    <div class="col-sm-7 col-md-8">
        <div class="row">
            <div class="col-sm-4">
                <span class="badge badge-secondary">Ctrl-F / Cmd-F</span> Поиск
            </div>
            <div class="col-sm-4">
                <span class="badge badge-secondary">Ctrl-G / Cmd-G</span> Найти следующий
            </div>
            <div class="col-sm-4">
                <span class="badge badge-secondary">Shift-Ctrl-G / Shift-Cmd-G</span> Найти предыдущий
            </div>
            <div class="col-sm-4">
                <span class="badge badge-secondary">Alt-G</span> Переход по линиям
            </div>
            <div class="col-sm-4">
                <span class="badge badge-secondary">Shift-Ctrl-F / Cmd-Option-F</span> Замена
            </div>
            <div class="col-sm-4">
                <span class="badge badge-secondary">Shift-Ctrl-R / Shift-Cmd-Option-F</span> Заменить все
            </div>
            <div class="col-sm-12">
                <span class="badge badge-secondary">Alt-F</span> Постоянный поиск (диалоговое окно не закрывается
                автоматически, нажмите Enter, чтобы найти следующее, Shift-Enter, чтобы найти предыдущее)
            </div>
        </div>


        <div id="data">
            <div class="contentTree code" style="display:none;">

                <?php
                /*$this->widget('ext.codemirror.CodeMirrorWidget', array(
                    'name' => 'code',
                    'target' => 'code',
                    'htmlOptions' => array('id' => 'code','class'=>'form-control')
                ));*/

                echo \panix\engine\widgets\CodeMirrorWidget::widget([
                    'name' => 'code',
                    'attribute' => 'code',
                    'options' => ['id' => 'code', 'class' => 'form-control']
                ])
                ?>


            </div>
            <div class="contentTree folder" style="display:none;"></div>
            <div class="contentTree image" style="display:none; position:relative;">
                <img src="" alt=""
                     style="display:block; position:absolute; left:50%; top:50%; padding:0; max-height:90%; max-width:90%;"/>
            </div>
            <div class="contentTree default" style="text-align:center;">Select a file from the tree.</div>
        </div>


        <div class="form-group text-center">
            <input type="submit" value="<?= Yii::t('app/default', 'SAVE') ?>" class="btn btn-success"/>
        </div>
    </div>
</div>

<?= Html::endForm() ?>


