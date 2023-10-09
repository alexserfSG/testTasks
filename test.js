function getRandomInt(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
    
class Creatures {

    constructor() {
        this.maxHealth = 50;
        this.health = 50;
        this.attack = getRandomInt(1,30);
        this.defense = getRandomInt(1,30);
        this.damage = {
            minDamage: Math.floor(this.attack / 6) + 1,
            maxDamage: Math.ceil(this.attack / 3) + 1
        }
    }

    attackTarget(attacker,defender) {

        let attackMod = (attacker.attack >= defender.defense)? (attacker.attack - defender.defense + 1) : 1;

        for (let i = 1; i <= attackMod; i++) {
            let trying = getRandomInt(1,6);
            if (trying > 4) {
                console.log(attacker.name + ' хорошенько врезал!');
                let damage = getRandomInt(attacker.damage.minDamage,attacker.damage.maxDamage);
                if (defender.health <= damage) {
                    defender.health = 0;
                    console.log('Бой окончен. ' + defender.name + ' повержен.');
                    console.log(defender);
                    console.log(attacker);
                    return true;
                } else {
                    defender.health -= damage;
                    console.log('У ' + defender.name + ' осталось ' + defender.health + ' здоровья');
                }
                break;
            }
        }
    }

    checkFighters(attacker,defender) {
        if (attacker instanceof Creatures && defender instanceof Creatures) return true;
        else {
            console.log('Бой невозможен. Участники боя выбраны некорректно.');
            return false;
        }
    }

    fight(attacker,defender) {
        if (!this.checkFighters(attacker,defender)) return false;


        for (let a = 1; a <= 40 ; a++) {

            if (a % 2 === 0) this.attackTarget(defender, attacker);
            else this.attackTarget(attacker,defender);

            if ((attacker.health <= attacker.maxHealth / 2) && attacker instanceof Player) {
                if (this.healthPotion.quantity !== 0) attacker.healYourself();
            }

            if ((defender.health <= defender.maxHealth / 2) && defender instanceof Player) {
                if (this.healthPotion.quantity !== 0) defender.healYourself();
            }

            if (attacker.health === 0 || defender.health === 0) break;
        }



    }

}

class RandomMonster extends Creatures {
    constructor() {
        super();
        const monsterType = ['Рыцарь Смерти' , 'Лоскутик' , 'Вампир' , 'Гаишник'];
        this.name = monsterType[getRandomInt(0,3)];
    }
}

class Player extends Creatures {
    constructor(name) {
        super();
        this.name = (typeof name === 'string')? name : 'Guest';
        this.healthPotion = {
            quantity: 4,
            healPower: Math.ceil(this.health * 0.3)
        };
    }

    healYourself() {

        let hp = null;
        if (this.healthPotion.quantity === 0) {
            console.log('Зелья лечения закончились...');
        } else {
            this.healthPotion.quantity = this.healthPotion.quantity - 1;
            hp = this.health + this.healthPotion.healPower;
            this.health = (hp <= this.maxHealth)? hp : this.maxHealth;
            console.log('Вы выпили зелье. Теперь у вас ' + this.health + ' здоровья!');
        }
    }
}

const p = new Player('Alex');
const m = new RandomMonster;
p.fight(p,m);
