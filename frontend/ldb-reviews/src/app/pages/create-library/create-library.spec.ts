import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateLibrary } from './create-library';

describe('CreateLibrary', () => {
  let component: CreateLibrary;
  let fixture: ComponentFixture<CreateLibrary>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CreateLibrary]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CreateLibrary);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
