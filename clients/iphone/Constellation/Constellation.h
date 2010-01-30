//
//  Constellation.h
//  Constellation
//
//  Created by Adam Venturella on 1/24/10.
//  Copyright 2010 __MyCompanyName__. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "GalaxyApplication.h"
#import "ConstellationDelegate.h"

@interface Constellation :  GalaxyApplication
{
	id<ConstellationDelegate> delegate;
}
@property (nonatomic, assign) id<ConstellationDelegate> delegate;
+ (Constellation *) constellationWithDelegate:(id<ConstellationDelegate>)delegate;
- (void)forums;
- (void)topics:(NSString *)channel page:(NSUInteger)page limit:(NSUInteger)limit;
- (void)messages:(NSString *)topic page:(NSUInteger)page limit:(NSUInteger)limit;
@end
