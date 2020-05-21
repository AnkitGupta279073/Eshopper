<?php
   use App\Product;
   ?>
<form action="{{ url('/products/filter') }}" method="post"> @csrf
   @if(!empty($url))
<input type="hidden" name="url" value="{{ $url }}">
   @endif
<div class="left-sidebar">
   <h2>Category</h2>
   <div class="panel-group category-products" id="accordian">
      <!--category-products-->
      @foreach($categories as $cat)
      <div class="panel panel-default">
         <div class="panel-heading">
            <h4 class="panel-title">
               <a data-toggle="collapse" data-parent="#accordian" href="#{{$cat->id}}">
               <span class="badge pull-right"><i class="fa fa-plus"></i></span>
               {{$cat->name}}
               </a>
            </h4>
         </div>
         <div id="{{$cat->id}}" class="panel-collapse collapse">
            <div class="panel-body">
               <ul>
                  @foreach($cat->categories as $subcat)
                  <?php $productCount = Product::productCount($subcat->id);?>
                  @if($subcat->status==1)
                  <li><a href="{{ asset('products/'.$subcat->url) }}">{{$subcat->name}} ({{ $productCount }}) </a></li>
                  @endif
                  @endforeach
               </ul>
            </div>
         </div>
      </div>
      @endforeach
   </div>
   <!--/category-products-->
   @if(!empty($url))
   <h2>Colors</h2>
   
   <div class="panel-group">
      @foreach($colorArray as $color)
      @if(!empty($_GET['color']))
         <?php $colorArr = explode('-',$_GET['color']); ?>
         @if(in_array($color,$colorArr))
            <?php $colorcheck = "checked"; ?>
         @else
           <?php  $colorcheck = ""; ?>
         @endif
      @else
     <?php  $colorcheck = ""; ?>
      @endif
      <div class="panel-heading">
         <h4 class="panel-title">
            <input type="checkbox" {{ $colorcheck }} name="colorFilter[]" id="{{$color}}" value="{{$color}}" onchange="javascipt:this.form.submit();" ><span class="badge pull-right"></span>
            {{$color}}
         </h4>
      </div>
      @endforeach
   </div>
   
<div>&nbsp;</div>
   <h2>Sleeve</h2>
  
   <div class="panel-group">
       @foreach($sleeveArray as $sleeve)
      @if(!empty($_GET['sleeve']))
         <?php $sleeveArr = explode('-',$_GET['sleeve']); ?>
         @if(in_array($sleeve,$sleeveArr))
            <?php $sleevecheck = "checked"; ?>
         @else
           <?php  $sleevecheck = ""; ?>
         @endif
      @else
     <?php  $sleevecheck = ""; ?>
      @endif
      <div class="panel-heading">
         <h4 class="panel-title">
            <input type="checkbox" {{ $sleevecheck }} name="sleeveFilter[]" id="{{$sleeve}}" value="{{$sleeve}}" onchange="javascipt:this.form.submit();" ><span class="badge pull-right"></span>
            {{$sleeve}}
         </h4>
      </div>
      @endforeach
   </div>
   <div>&nbsp;</div>

    <h2>Pattern</h2>
   
   <div class="panel-group">
      @foreach($patternArray as $pattern)
      @if(!empty($_GET['pattern']))
         <?php $patternArr = explode('-',$_GET['pattern']); ?>
         @if(in_array($pattern,$patternArr))
            <?php $patterncheck = "checked"; ?>
         @else
           <?php  $patterncheck = ""; ?>
         @endif
      @else
     <?php  $patterncheck = ""; ?>
      @endif
      <div class="panel-heading">
         <h4 class="panel-title">
            <input type="checkbox" {{ $patterncheck }} name="patternFilter[]" id="{{$pattern}}" value="{{$pattern}}" onchange="javascipt:this.form.submit();" ><span class="badge pull-right"></span>
            {{$pattern}}
         </h4>
      </div>
       @endforeach
   </div>
  
<div>&nbsp;</div>
 <h2>Size</h2>
<div class="panel-group">
      @foreach($sizeArray as $size)
      @if(!empty($_GET['size']))
         <?php $sizeArr = explode('-',$_GET['size']); ?>
         @if(in_array($size,$sizeArr))
            <?php $sizecheck = "checked"; ?>
         @else
           <?php  $sizecheck = ""; ?>
         @endif
      @else
     <?php  $sizecheck = ""; ?>
      @endif
      <div class="panel-heading">
         <h4 class="panel-title">
            <input type="checkbox" {{ $sizecheck }} name="sizeFilter[]" id="{{$size}}" value="{{$size}}" onchange="javascipt:this.form.submit();" ><span class="badge pull-right"></span>
            {{$size}}
         </h4>
      </div>
       @endforeach
   </div>
   @endif
</div>
</form>