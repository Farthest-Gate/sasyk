
                            <div class="input-group">
                                <span class="input-group-prepend ">
                                    <button class="btn-outline icon-selected border-0" type="btn button" style="width:40px;font-size: 1.4em;">
                                        
                                    </button>
                                </span>
                                <input class="form-control border-0 icon-search" type="search" name="icon-search" placeholder="Search Icons">
                                
                            </div>
                            
                            <div class="form-control fg-fix-width icon-picker" style="height:220px;overflow:scroll;font-size:1.8em;">
                                <div class="row">
                                @isset($icons)
                                    @foreach($icons as $icon)
                                        <div class="col-2 icon-individual clickable">
                                            <i class="{{$icon}}"></i>
                                        </div>
                                    @endforeach
                                @endif
                                </div>
                            </div>