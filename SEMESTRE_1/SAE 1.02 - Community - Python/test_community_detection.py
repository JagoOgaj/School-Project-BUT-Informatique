from community_detection import *




################ tests unitaires create_network ################
tab_1 = ["Mamadou","Caroline","Issa","Ricardo","Issa","Loic"]
tab_2 = ["Caroline","Fatou","Kameto","Gotaga","Gotaga","Squeezie"]
tab_3 = ["Soso","Zizou","Soso","Ronaldo","Soso","Rodriguo"]

def test_create_network():
    assert create_network(tab_1) == {'Mamadou': ['Caroline'], 'Caroline': ['Mamadou'], 'Issa': ['Ricardo', 'Loic'], 'Ricardo': ['Issa'], 'Loic': ['Issa']}
    assert create_network(tab_2) == {'Caroline': ['Fatou'], 'Fatou': ['Caroline'], 'Kameto': ['Gotaga'], 'Gotaga': ['Kameto', 'Squeezie'], 'Squeezie': ['Gotaga']}
    assert create_network(tab_3) == {'Soso': ['Zizou', 'Ronaldo', 'Rodriguo'], 'Zizou': ['Soso'], 'Ronaldo': ['Soso'], 'Rodriguo': ['Soso']}
    print("test_create_network ok")
    
test_create_network()
################ tests unitaires create_network ################




################ tests unitaires get_people ################
network_1 = {'Mamadou': ['Caroline'], 'Caroline': ['Mamadou'], 'Paul': ['Ricardo', 'Loic'], 'Ricardo': ['Paul'], 'Loic': ['Paul']}
network_2 = {'Caroline': ['Fatou'], 'Fatou': ['Caroline'], 'Kameto': ['Gotaga'], 'Gotaga': ['Kameto', 'Squeezie'], 'Squeezie': ['Gotaga']} 
network_3 = {'Soso': ['Zizou', 'Ronaldo', 'Rodriguo'], 'Zizou': ['Soso'], 'Ronaldo': ['Soso'], 'Rodriguo': ['Soso']}

def test_get_people():
    assert get_people(network_1) == ["Mamadou","Caroline","Paul","Ricardo","Loic"]
    assert get_people(network_2) == ["Caroline","Fatou","Kameto","Gotaga","Squeezie"]
    assert get_people(network_3) == ["Soso","Zizou","Ronaldo","Rodriguo"]
    print("test_get_people ok")
    
    
test_get_people()
################ tests unitaires get_people ################




################ tests unitaires are_friends ################
def test_are_friends():
    assert are_friends(network_1, "Mamadou","Caroline") == True
    assert are_friends(network_2, "Fatou","Kameto") == False
    assert are_friends(network_3, "Soso", "Zizou") == True 
    print("test_are_friends ok")

test_are_friends()
################ tests unitaires are_friends ################




################ tests unitaires all_his_friends ################
def test_all_his_friends():
    assert all_his_friends(network_1, "Paul", ["Ricardo", "Caroline"]) == False
    assert all_his_friends(network_3, 'Soso', ['Zizou', 'Ronaldo', 'Rodriguo']) == True 
    assert all_his_friends(network_2, "Gotaga", ["Kameto", "Squeezie"]) == True 
    print("test_all_his_friends ok")
    
test_all_his_friends()
################ tests unitaires all_his_friends ################




################ tests unitaires is_a_community ################
def test_is_a_community():
    assert is_a_community(network_3, ["Soso","Zizou","Ronaldo","Rodriguo"]) == False
    assert is_a_community(network_2, ["Gotaga","Squeezie"]) == True 
    assert is_a_community(network_1, ["Ricardo","Paul","Loic"]) == False
    print("test_is_a_community ok")
    
test_is_a_community()
################ tests unitaires is_a_community ################




################ tests unitaires get_people ################
def test_find_community():
    assert find_community(network_2, ["Gotaga","Kameto","Squeezie","Fatou"]) == ["Gotaga","Kameto","Squeezie"]
    assert find_community(network_1, ["Mamadou","Caroline","Paul"]) == ["Mamadou","Caroline"]
    assert find_community(network_3, ["Rodriguo","Soso","Zizou","Ronaldo"]) == ["Rodriguo","Soso"]
    print("test_find_community ok")
    
test_find_community()
################ tests unitaires get_people ################




################ tests unitaires order_by_decreasing_popularity ################
def test_order_by_decreasing_popularity():
    assert order_by_decreasing_popularity(network_2, ["Caroline","Fatou"]) == ["Fatou","Caroline"]
    assert order_by_decreasing_popularity(network_1,['Mamadou', 'Caroline']) == ['Mamadou', 'Caroline']
    assert order_by_decreasing_popularity(network_3,['Soso', 'Zizou', 'Ronaldo', 'Rodriguo']) != ["Ronaldo","Zizou","Rodriguo","Soso"]
    print("test_order_by_decreasing_popularity ok")
    
test_order_by_decreasing_popularity()
################ tests unitaires order_by_decreasing_popularity ################




################ tests unitaires find_community_by_decreasing_popularity ################
def test_find_community_by_decreasing_popularity():
    assert find_community_by_decreasing_popularity(network_2) == ["Fatou","Caroline"]
    assert find_community_by_decreasing_popularity(network_1) == ['Mamadou', 'Caroline']
    assert find_community_by_decreasing_popularity(network_3) == ['Soso', 'Zizou', 'Ronaldo', 'Rodriguo']
    print("test_find_community_by_decreasing_popularity ok")
    
test_find_community_by_decreasing_popularity()
################ tests unitaires find_community_by_decreasing_popularity ################




################ tests unitaires find_community_from_person ################
def test_find_community_from_person():
    assert find_community_from_person(network_1, "Paul") == ['Paul', 'Loic', 'Ricardo']
    assert find_community_from_person(network_2, "Caroline") == ['Caroline', 'Fatou']
    assert find_community_from_person(network_2, "Kameto") == ['Kameto', 'Gotaga']
    print("test_find_community_from_person ok")
    
test_find_community_from_person()
################ tests unitaires find_community_from_person ################




################ tests unitaires find_max_community ################
def test_find_max_community():
    assert find_max_community(network_1) == ['Paul', 'Ricardo']
    assert find_max_community(network_2) == ['Gotaga', 'Squeezie']
    assert find_max_community(network_3) == ['Soso', 'Zizou']
    print("test_find_max_community ok")
    
test_find_max_community()
################ tests unitaires find_max_community ################