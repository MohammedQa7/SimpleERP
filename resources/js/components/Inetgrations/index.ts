import { defineAsyncComponent } from "vue";

export const getProviderDialog = {
    slack: 'SlackSettingsDialog',
    outlook: 'OutlookDialog',
}


export function resolveProviderDialog(folderName: string, provider: string) {
    const dialogPath = './Providers'
    const modules = import.meta.glob('../../components/Inetgrations/Providers/**/**.vue');
    const key = `${dialogPath}/${folderName}/${provider}.vue`

    const loader = modules[key];

    if (loader == undefined) {
        return false;
    }

    return loader ? defineAsyncComponent(loader as any) : null
}