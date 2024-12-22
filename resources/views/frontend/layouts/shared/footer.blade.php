    <!-- footer -->
     <footer class="footer">
        <div class="childfooter">
          <h1>Made With Care.</h1>
          <img
            src="{{ asset('assets/frontend/img/LandingPage/footer.png') }}"
            alt="Blood drop icon"
            height="30"
          />
        </div>
     </footer>
      <!-- footer -->
      <script src="{{ asset('assets/frontend/script/utils/drawer.js') }}"></script>
      <script src="{{ asset('assets/frontend/script/alert.js') }}"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.1/dist/sweetalert2.all.min.js"></script>
      @yield('js-section')
</body>
</html>
