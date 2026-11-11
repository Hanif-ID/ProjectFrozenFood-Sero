<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('assets/') }}/"
  data-template="vertical-menu-template-free"
>
  <head>
    @include('layouts.header')
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        
        <!-- Menu Sidebar -->
        @include('layouts.sidebar')

        <!-- Layout container -->
        <div class="layout-page">
          
          <!-- Navbar -->
          @include('layouts.navbar')

          <!-- Content wrapper -->
          <div class="content-wrapper">
            
            <!-- Main Content -->
            @yield('content')

            <!-- Footer -->
            @include('layouts.footer')

            <div class="content-backdrop fade"></div>
          </div>
          <!-- / Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Upgrade to Pro Button -->
    <div class="buy-now">
      <a
        href="https://themeselection.com/products/sneat-bootstrap-html-admin-template/"
        target="_blank"
        class="btn btn-danger btn-buy-now"
        >Upgrade to Pro</a
      >
    </div>

    <!-- Scripts -->
    @include('layouts.scripts')
  </body>
</html>