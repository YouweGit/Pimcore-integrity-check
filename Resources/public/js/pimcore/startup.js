pimcore.registerNS("pimcore.plugin.IntegrityCheckBundle");

pimcore.plugin.IntegrityCheckBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.IntegrityCheckBundle";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);
    },

    pimcoreReady: function (params, broker) {

        /**
         * Overwrite the existing removing functionality
         *
         * @param options
         * @param response
         */
        pimcore.elementservice.deleteElementCheckDependencyComplete = function (options, response) {

            try {
                var res = Ext.decode(response.responseText);
                var message = res.batchDelete ? t('delete_message_batch') : t('delete_message');
                if (res.elementKey) {
                    message += "<br /><b style='display: block; text-align: center; padding: 10px 0;'>\"" + htmlspecialchars(res.elementKey) + "\"</b>";
                }

                if(res["childs"] > 100) {
                    message += "<br /><br /><b>" + t("too_many_children_for_recyclebin") + "</b>";
                }

                var deleteMethod = "delete" + ucfirst(options.elementType) + "FromServer";

                if (res.hasDependencies) {
                    this.window = new Ext.window.Window({
                        title: t('Warning: Unable to delete the element'),
                        items: [
                            {
                                xtype: 'panel',
                                layout: 'table',
                                bodyStyle: 'margin: 10px; margin-top: 40px;',
                                html:  t('We are not able to remove this element because it is required by other elements'),
                            }
                        ],
                        modal: true,
                        resizeable: false,
                        layout: 'fit',
                        width: 550,
                        height: 150
                    }).show();
                } else {
                    Ext.MessageBox.show({
                        title: t('delete'),
                        msg: message,
                        buttons: Ext.Msg.OKCANCEL,
                        icon: Ext.MessageBox.INFO,
                        fn: pimcore.elementservice.deleteElementFromServer.bind(window, res, options)
                    });
                }
            }
            catch (e) {
                console.log(e);
            }
        };
    }
});

var IntegrityCheckBundlePlugin = new pimcore.plugin.IntegrityCheckBundle();

