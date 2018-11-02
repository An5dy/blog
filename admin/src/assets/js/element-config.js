import {
    Menu,
    Submenu,
    MenuItemGroup,
    MenuItem,
    Dropdown,
    DropdownMenu,
    DropdownItem,
    Scrollbar,
    Breadcrumb,
    BreadcrumbItem,
    Table,
    TableColumn,
    Form,
    Select,
    Option,
    FormItem,
    Input,
    Upload,
    Button,
    Dialog,
    Tooltip,
    Autocomplete,
    Transfer,
    Switch,
    Tag,
    Pagination,
    Tree,
    Loading,
    MessageBox,
    Message,
    Notification
} from "element-ui";

export default {
    install(V) {
        V.use(Menu);
        V.use(Submenu);
        V.use(MenuItem);
        V.use(MenuItemGroup);
        V.use(Dropdown);
        V.use(DropdownMenu);
        V.use(DropdownItem);
        V.use(Scrollbar);
        V.use(Breadcrumb);
        V.use(BreadcrumbItem);
        V.use(Table);
        V.use(TableColumn);
        V.use(Form);
        V.use(Select);
        V.use(Option);
        V.use(FormItem);
        V.use(Input);
        V.use(Upload);
        V.use(Button);
        V.use(Dialog);
        V.use(Tooltip);
        V.use(Autocomplete);
        V.use(Transfer);
        V.use(Switch);
        V.use(Tag);
        V.use(Pagination);
        V.use(Tree);
        V.use(Loading.directive);
        V.prototype.$confirm = MessageBox.confirm;
        V.prototype.$message = Message;
        V.prototype.$notify = Notification;
    }
};
