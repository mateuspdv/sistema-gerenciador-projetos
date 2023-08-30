import { Component, OnInit } from '@angular/core';
import { LocalDataSource } from 'ng2-smart-table';
import { ProjectService } from '../../services/project.service';
import { DatePipe } from '@angular/common';

@Component({
  selector: 'ngx-project-list',
  templateUrl: './project-list.component.html',
  styleUrls: ['./project-list.component.scss']
})
export class ProjectListComponent implements OnInit {

  source: LocalDataSource = new LocalDataSource();

  constructor(private projectService: ProjectService,
              private datePipe: DatePipe) { }

  ngOnInit(): void {
    this.findAll();
  }

  settings = {
    columns: {
      name: {
        title: 'Nome',
        type: 'string',
        filter: false
      },
      description: {
        title: 'Descrição',
        type: 'string',
        filter: false
      },
      startDate: {
        title: 'Data de Início',
        type: 'date',
        filter: false,
        valuePrepareFunction: (value) => {
          let startDate = new Date(value);
          return this.datePipe.transform(startDate.toISOString().split('T')[0], 'dd/MM/yyyy');
        },
      },
      endDate: {
        title: 'Data de Fim',
        type: 'string',
        filter: false,
        valuePrepareFunction: (value) => {
          let endDate = new Date(value);
          return this.datePipe.transform(endDate.toISOString().split('T')[0], 'dd/MM/yyyy');
        },
      },
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
      columnTitle: 'Ações',
      position: 'right',
    },
    hideSubHeader: true,
    noDataMessage: 'Nenhum dado encontrado'
  };

  findAll(): void {
    this.projectService.index().subscribe({
      next: (response) => {
        this.source.load(response);
      },
      error: (error) => {
        console.log(error);
      }
    });
  }

  onDeleteConfirm(event): void {
    if (window.confirm('Are you sure you want to delete?')) {
      event.confirm.resolve();
    } else {
      event.confirm.reject();
    }
  }

}
