<footer class="footer footer-static footer-light">
    <p class="clearfix mb-0">
        <span class="float-md-left d-block d-md-inline-block mt-25">VAINKEURZ  ©<?php echo date('Y'); ?>
            <a class="ml-25" href="<?php the_permalink(104853); ?>">A propos</a>
            -
            <a class="ml-25" href="<?php the_permalink(get_page_by_path('ml')); ?>">CGU</a>
            -
            <a class="ml-25" href="mailto:vainkeurz@gmail.com">Nous contacter</a>
        </span>
        <span class="float-md-right d-none d-md-block">
            <a href="https://discord.gg/w882sUnrhE" class="btn-footer" target="_blank">
                Discord
            </a>
            <span class="space"></span>
            <a href="https://twitter.com/Vainkeurz" target="_blank" class="btn-footer">
                Twitter
            </a>
            <span class="space"></span>
            <a href="https://www.facebook.com/vainkeurz" target="_blank" class="btn-footer">
                Facebook
            </a>
        </span>
    </p>
</footer>

<!-- Scripts -->
<script>
    const vkrz_ajaxurl  = "<?= admin_url('admin-ajax.php') ?>";
</script>

<?php wp_footer(); ?>

<?php if(is_author() || is_page(27040)): ?>
    <script src="<?php bloginfo('template_directory'); ?>/assets/js/scripts/cards/card-analytics.js"></script>
    <script src="<?php bloginfo('template_directory'); ?>/assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="<?php bloginfo('template_directory'); ?>/assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="<?php bloginfo('template_directory'); ?>/assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
    <script src="<?php bloginfo('template_directory'); ?>/assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
    <script src="<?php bloginfo('template_directory'); ?>/assets/vendors/js/tables/datatable/responsive.bootstrap.min.js"></script>
    <script>
        $('.table-c5_2').DataTable({
            autoWidth: false,
            lengthMenu: [5000],
            columns: [
                { orderable: false },
                null,
                null,
                null,
                { orderable: false },
            ],
            order: [[1, 'asc']],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Rechercher...",
                processing:     "Traitement en cours...",
                info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                infoPostFix:    "",
                loadingRecords: "Chargement en cours...",
                zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher 😩",
                emptyTable:     "Aucun résultat trouvé 😩",
                paginate: {
                    first:      "Premier",
                    previous:   "Pr&eacute;c&eacute;dent",
                    next:       "Suivant",
                    last:       "Dernier"
                },
            }
        });
        $('.table-c5').DataTable({
            autoWidth: false,
            lengthMenu: [5000],
            columns: [
                { orderable: false },
                { orderable: false },
                { orderable: false },
                null,
                { orderable: false },
            ],
            order: [[1, 'asc']],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Rechercher...",
                processing:     "Traitement en cours...",
                info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                infoPostFix:    "",
                loadingRecords: "Chargement en cours...",
                zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher 😩",
                emptyTable:     "Aucun résultat trouvé 😩",
                paginate: {
                    first:      "Premier",
                    previous:   "Pr&eacute;c&eacute;dent",
                    next:       "Suivant",
                    last:       "Dernier"
                },
            }
        });
        $('.table-c7').DataTable({
            autoWidth: false,
            lengthMenu: [5000],
            columns: [
                { orderable: false },
                { orderable: false },
                { orderable: false },
                { orderable: false },
                null,
                { orderable: false },
                { orderable: false }
            ],
            order: [[1, 'asc']],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Rechercher...",
                processing:     "Traitement en cours...",
                info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                infoPostFix:    "",
                loadingRecords: "Chargement en cours...",
                zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher 😩",
                emptyTable:     "Aucun résultat trouvé 😩",
                paginate: {
                    first:      "Premier",
                    previous:   "Pr&eacute;c&eacute;dent",
                    next:       "Suivant",
                    last:       "Dernier"
                },
            }
        });
    </script>
<?php endif; ?>

</body>
</html>