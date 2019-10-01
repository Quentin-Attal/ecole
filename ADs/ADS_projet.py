import sys

sys.setrecursionlimit(1500)


def naif(index=0, symbol=None):
    if index == len(T):
        return 0
    d = A if symbol == C[index] else B
    max1 = T[index] * d + naif(index + 1, C[index])
    max2 = naif(index + 1, symbol)
    return max(max2, max1)


def begin_glutton(index=0, symbole=None):
    track = []
    return glutton(index, symbole, track)


def glutton(index, symbol, track):
    if index == len(T):
        return 0
    d = A if symbol == C[index] else B
    track.append(index) if T[index] * d >= 0 else None
    max1 = glutton(index + 1, C[index], track) + T[index] * d if T[index] * d >= 0 else glutton(index + 1, symbol,
                                                                                                track)
    if index == 0:
        return max1, track
    return max1


def top_down(index, track):
    if index == len(T):
        return 0

    elif track[index][0] > 0:

        if len(T) - 1 == index:
            return track[index][1]
        else:
            if track[index + 1][2] == track[index][2]:
                DANA = index + 1
                while track[DANA][2] == track[index][2]:
                    if track[index][0] > track[DANA][0]:
                        if track[index][0] * B + track[DANA][0] * A > track[index][0] * B:
                            track[DANA][1] = track[DANA][1] - (track[DANA][0] * B) + track[DANA][0] * A
                            track[index][1] = track[DANA][1] + track[index][0] * B
                        else:
                            track[DANA][0] = track[index][0]
                            track[index][1] += abs(track[DANA][0] - track[index][0]) * B
                    elif track[index][0] < track[DANA][0]:
                        track[index][1] = track[DANA][1]

                    DANA += 1
                return track[index][1]
            else:
                return track[index][1]
    else:
        if index < len(T) - 1:
            d = A if track[index + 1][2] == C[index] else B
        else:
            d = B
        max1 = T[index] * d + top_down(index + 1, track)
        max2 = top_down(index + 1, track)
        track[index][2] = C[index]
        track[index][0] = T[index]
        track[index][1] = max(max2, max1)
        if index == 0:
            if d == A:
                max1 = track[index][1] + abs(track[index + 1][0] - track[index][0]) * B
                track[index][2] = C[index]
                track[index][0] = T[index]
                track[index][1] = max(max2, max1)
        return track[index][1]


def top_down2(index, track):
    if index == len(T):
        return 0

    elif track[index][0] > 0:
        if track[index + 1][2] == track[index][2]:
            DANA = index + 1
            while track[DANA][2] == track[index][2]:
                if track[DANA][0] < track[index][0]:
                    track[DANA][0] = track[index][0]
                    track[index][1] += abs(track[DANA][0] - track[index][0]) * B
                DANA += 1
            return track[index][1]
        else:
            return track[index][1]
    else:
        if index < len(T) - 1:
            d = A if track[index + 1][2] == C[index] else B
        else:
            d = B
        max1 = T[index] * d + top_down(index + 1, track)
        max2 = top_down(index + 1, track)
        track[index][2] = C[index]
        track[index][0] = T[index]
        track[index][1] = max(max2, max1)
        if index == 0:
            if d == A:
                if track[index + 1][0] < track[index][0]:
                    max1 = track[index][1] + abs(track[index + 1][0] - track[index][0]) * B
                track[index][2] = C[index]
                track[index][0] = T[index]
                track[index][1] = max(max2, max1)
            tab = []
            somme = 0
            for i in range(0, len(T)):
                if track[i][1] != track[i + 1][1]:
                    somme += B * track[i][0]
                    tab.append(somme)
            return somme
        return track[index][1]


def begin_top_down():
    track = [[0, -1, C[i] if i < len(C) else None] for i in range(len(T) + 1)]
    index = 0
    if B > 0 > A:
        return top_down2(index, track)
    else:
        return top_down(index, track)


# def bottom_up():
#     liste = []
#     w = -1
#     symbol = None
#     for j in range(0, len(T)):
#         if symbol == C[j]:
#             liste[w].append(T[j])
#         else:
#             liste.append([T[j]])
#             w += 1
#             symbol = C[j]
#     maxi = 0
#     symbol = None
#     for i in range(len(liste)):
#         max = 0
#         for j in range(len(liste[i])):
#             if symbol != liste[i][j]:
#                 maxi += B * liste[i][j]
#                 symbol = liste[i][j]
#             else:
#                 maxi += A * liste[i][j]
#     return liste


A = -3
B = -7
T = []
C = []

# T = []
# C = []
# A = -5
# B = 4


with open("MP.txt", 'r')as f:
    for line in f.read().splitlines():
        mot = line.split(' ')
        T.append(int(mot[0]))
        C.append(int(mot[1]))


# soit creer une autre liste qui stocke

def bottom_up():
    somme = 0
    index = None
    info = 0
    var = None
    track = []
    if A < 0 and B < 0:
        return somme, track
    for i in range(len(T)):
        d = A if index == C[i] else B
        if d == A:
            y = 0 if A < 0 else A * T[i]
            if B * T[i] + somme - abs(B * T[var]) > somme + y:
                del track[-1]
                track.append(i)
                max1 = B * T[i] + somme - B * T[var]
                for j in range(var, i - 1):
                    if index == C[i] and A > 0:
                        max1 -= abs(A * T[j])
                var = i
            else:
                max1 = max(somme, d * T[i] + somme)
                if somme < d * T[i] + somme:
                    track.append(i)
        else:
            max1 = d * T[i] + somme
            var = i
        max2 = somme
        somme = max(max1, max2)
        if somme == max1:
            index = C[i]
            if d == B:
                track.append(i)
        else:
            init = 0
            new_somme = 0
            pos_i = info
            for j in range(pos_i, i + 1):
                if C[i] == C[j]:
                    if init == 0:
                        new_somme += B * T[j]
                        init += 1
                    else:
                        max1 = B * T[j]
                        max2 = new_somme + A * T[j]
                        if max1 > max2:
                            new_somme = max1
                        else:
                            new_somme = max2
                else:
                    if init == 0:
                        continue
                    else:
                        if C[j] == index:
                            new_somme -= A * T[j]
            if new_somme + somme > somme:
                somme += new_somme
                new_somme = 0
                for j in range(pos_i, i + 1):
                    if C[i] == C[j]:
                        if init == 0:
                            new_somme += B * T[j]
                            init += 1
                        else:
                            max1 = B * T[j]
                            max2 = new_somme + A * T[j]
                            if max1 > max2:
                                new_somme = max1
                            else:
                                new_somme = max2
                                track.append(j)

                    else:
                        if init == 0:
                            continue
                        else:
                            if C[j] == index:
                                new_somme -= A * T[j]
                                del track[-1]
                index = C[i]
                info = i

    return somme, track


# print(naif())
print(begin_glutton()[1])
print(begin_glutton()[0])
print(begin_top_down())
print(bottom_up()[0])
print(bottom_up()[1])
