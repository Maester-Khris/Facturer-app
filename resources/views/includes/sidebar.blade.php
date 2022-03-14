    <div class="brand-logo">
        <a href="index.html">
            <h4 style="color: white;">FACTURER APP</h4>
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-monitor"></span><span class="mtext">Administration</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{  url('nouvellesEntites')  }}" id="linkNE">Nouvelles Entités</a></li>
                        <li><a href="{{  url('descriptionSociete')  }}" id="linkDS">Description de la société</a></li>
                        <li><a href="{{  url('planCompte')  }}" id="linkPC">Plan de Compte</a></li>
                        <li><a href="{{  url('balanceCompte')  }}" id="linkBC">Balance de Compte</a></li>
                        <li><a href="{{  url('suiviActivites')  }}" id="linkSA">Suivi des Activités</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-balance"></span><span class="mtext">Controle de Stocks</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{  url('interrogerArticles')  }}" id="linkIA">Interroger Articles</a></li>
                        <li><a href="{{ url('mouvementsStock') }}" id="linkMS">Mouvements de Stocks</a></li>
                        <li><a href="{{ url('situiationDepots') }}"  id="linkSD">Situation dépot</a></li>
                        <li><a href="{{ url('inventaire') }}" id="linkI">Inventaire</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-suitcase-11"></span><span class="mtext">Section Achat</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ url('nouvelleFacture') }}" id="linkNFA">Nouvelle Facture</a></li>
                        <li><a href="{{ url('compteFournisseur') }}" id="linkICF">Interroger Compte Fourni.</a></li>
                        <li><a href="{{ url('facturesFournisseur') }}" id="linkFF">Liste Facture Fourni.</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-deal"></span><span class="mtext">Section Vente</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ url('nouvelleFactureVente') }}" id="linkNewFactureClient">Nouvelle Facture</a></li>
                        <li><a href="{{ url('interrogerCompteClient') }}" id="linkICC">Interroger Compte Client</a></li>
                        <li><a href="{{ url('listeFacturesClient') }}" id="linkLFC">Liste Facture Client</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ url('ventesComptoir') }}" class="dropdown-toggle no-arrow" id="linkVenteComptoir">
                        <span class="micon dw dw-shopping-cart"></span><span class="mtext">Ventes au comptoir</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>