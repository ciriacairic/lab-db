import { TestBed } from '@angular/core/testing';

import { Backend } from './backend';

describe('Backend', () => {
  let service: Backend;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(Backend);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
