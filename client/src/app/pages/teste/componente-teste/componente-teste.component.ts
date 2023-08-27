import { filter } from 'rxjs/operators';
import { Component, OnInit } from '@angular/core';
import { LocalDataSource } from 'ng2-smart-table';

@Component({
  selector: 'ngx-componente-teste',
  templateUrl: './componente-teste.component.html',
  styleUrls: ['./componente-teste.component.scss']
})
export class ComponenteTesteComponent implements OnInit {

  valores: any = [
    { nome: 'Mateus', sobrenome: 'Padovan', profissao: 'Programador', testeCampo: 'teste' }
  ]

  source: LocalDataSource = new LocalDataSource();

  constructor() { }

  ngOnInit(): void {
    this.source.load(this.valores);
  }

  settings = {
    columns: {
      nome: { title: 'Nome', type: 'string', filter: false },
      sobrenome: { title: 'Sobrenome', type: 'string', filter: false },
      profissao: { title: 'Profissão', type: 'string', filter: false },
    },
    add: {
      addButtonContent: '<i class="nb-plus"></i>',
      createButtonContent: '<i class="nb-checkmark"></i>',
      cancelButtonContent: '<i class="nb-close"></i>',
    },
    edit: {
      editButtonContent: '<i class="nb-edit"></i>',
      saveButtonContent: '<i class="nb-checkmark"></i>',
      cancelButtonContent: '<i class="nb-close"></i>',
    },
    delete: {
      deleteButtonContent: '<i class="nb-trash"></i>',
      confirmDelete: true,
    },
    actions: {
      add: false,
      columnTitle: 'Ações',
      position: 'right'
    },
    hideSubHeader: true,
  };

  onDeleteConfirm(event): void {
    if (window.confirm('Are you sure you want to delete?')) {
      event.confirm.resolve();
    } else {
      event.confirm.reject();
    }
  }

}
