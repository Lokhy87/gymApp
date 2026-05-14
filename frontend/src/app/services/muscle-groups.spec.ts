import { TestBed } from '@angular/core/testing';

import { MuscleGroupService } from './muscle-groups';

describe('MuscleGroup', () => {
  let service: MuscleGroupService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(MuscleGroupService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
