<div  class="table-container">
  <div class="table-header">
    <div class="table-header-buttons">
      <ul>
        <li class="filter-button-active">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>filter-check</title><path d="M12 12V19.88C12.04 20.18 11.94 20.5 11.71 20.71C11.32 21.1 10.69 21.1 10.3 20.71L8.29 18.7C8.06 18.47 7.96 18.16 8 17.87V12H7.97L2.21 4.62C1.87 4.19 1.95 3.56 2.38 3.22C2.57 3.08 2.78 3 3 3H17C17.22 3 17.43 3.08 17.62 3.22C18.05 3.56 18.13 4.19 17.79 4.62L12.03 12H12M17.75 21L15 18L16.16 16.84L17.75 18.43L21.34 14.84L22.5 16.25L17.75 21" /></svg>
        </li>
        <li class="filter-cancel-button">          
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M14.76,20.83L17.6,18L14.76,15.17L16.17,13.76L19,16.57L21.83,13.76L23.24,15.17L20.43,18L23.24,20.83L21.83,22.24L19,19.4L16.17,22.24L14.76,20.83M12,12V19.88C12.04,20.18 11.94,20.5 11.71,20.71C11.32,21.1 10.69,21.1 10.3,20.71L8.29,18.7C8.06,18.47 7.96,18.16 8,17.87V12H7.97L2.21,4.62C1.87,4.19 1.95,3.56 2.38,3.22C2.57,3.08 2.78,3 3,3V3H17V3C17.22,3 17.43,3.08 17.62,3.22C18.05,3.56 18.13,4.19 17.79,4.62L12.03,12H12Z" /></svg>
        </li>
      </ul>
    </div>
  </div>
  <div class="table-body">
    @foreach($records as $record)
      <div class="table-row">
        <div class="table-row-element">
          <p>{{ $record->name }}</p>
        </div>
        <div class="table-row-element">
          <p>{{ $record->email }}</p>
        </div>
        <div class="table-row-element">
          <p>{{ $record->created_at }}</p>
        </div>
        <div class="table-row-element">
          <p>{{ $record->updated_at }}</p>
        </div>
      </div>
    @endforeach
  </div>
  <div class="table-footer">
    <div class="table-info">               
      <div class="table-page-buttons">
        <div class="table-page-button" data-page="1">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.41,7.41L17,6L11,12L17,18L18.41,16.59L13.83,12L18.41,7.41M12.41,7.41L11,6L5,12L11,18L12.41,16.59L7.83,12L12.41,7.41Z" /></svg>
        </div>  
        <div class="table-page-button" data-page="{{ $records->currentPage() > 1 ? $records->currentPage() - 1 : 1 }}">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>chevron-left</title><path d="M15.41,16.58L10.83,12L15.41,7.41L14,6L8,12L14,18L15.41,16.58Z" /></svg>                     
        </div>  
        <div class="current-page">
          <label>
            <input type="number" value="{{ $records->currentPage() }}"> 
            <button class="go-to-page">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M4,10V14H13L9.5,17.5L11.92,19.92L19.84,12L11.92,4.08L9.5,6.5L13,10H4Z" /></svg>
            </button>
          </label>
        </div>
        <div class="table-page-button" data-page="${parseInt(this.data.meta.currentPage) + 1}">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>chevron-right</title><path d="M8.59,16.58L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.58Z" /></svg>
        </div>  
        <div class="table-page-button" data-page="${this.data.meta.pages}">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>chevron-double-right</title><path d="M5.59,7.41L7,6L13,12L7,18L5.59,16.59L10.17,12L5.59,7.41M11.59,7.41L13,6L19,12L13,18L11.59,16.59L16.17,12L11.59,7.41Z" /></svg>                      
        </div>  
      </div>                 
    </div>
  </div>
</div>